<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Site;
use App\Models\User;
use App\Models\Machine;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesLog;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class HandleAccessControlEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $eventLog;
    protected $picturePath;
    /**
     * Create a new job instance.
     */
    public function __construct($eventLog, $picturePath)
    {
        $this->eventLog = $eventLog;
        $this->picturePath = $picturePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Log::info($request->input('event_log'));
        // die;

        $log = array();
        $eventLog = $this->eventLog;
        $ipAddress = $eventLog['ipAddress'];
        $log['ipAddress'] = $ipAddress;
        $eventData = $eventLog['AccessControllerEvent'];

        // Format timestamp dari event log
        $timestamp = Carbon::parse($eventLog['dateTime'])->format('Y-m-d H:i:s');

        $site = Site::find(1);
        $machine = Machine::where('ip_address', $ipAddress)->first();
        if ($machine === null) {
            Log::error("Machine with IP address {$ipAddress} not found");
            return;
        }
        // Tentukan apakah ini event masuk atau keluar berdasarkan IP address
        $eventType = $ipAddress === '192.168.20.202' ? 'out' : ($ipAddress === '192.168.20.201' ? 'in' : null);

        if (!$eventType) {
            Log::error('Invalid IP address');
            return;
        }

        DB::beginTransaction();
        try {
            if (empty($eventData['employeeNoString'])) {
                Log::error('Invalid employeeNoString, timestamp: ' . $timestamp . ' EventType: '. $eventType);
                return;
            }

            if(empty($eventData['serialNo']))
            {
                Log::error('Invalid serialNo, timestamp: ' . $timestamp . ' EventType: '. $eventType);
                return;
            }

            // Cek apakah user sudah ada berdasarkan employeeNoString
            $user = User::where('username', $eventData['employeeNoString'])->first();

            if (!$user) {
                $password = Str::random(8);
                $avatarUrl = null;
                $avatarThumbnailUrl = null;
                $avatarPath = null;
                $avatarThumbnailPath = null;

                $uid = Str::uuid();
                if ($this->picturePath) {
                    $uid = Str::uuid();
                    $avatarPath = 'avatars/' . $uid . '.jpg';

                    // Ambil file dari storage sementara
                    $picture = Storage::get($this->picturePath);

                    // Simpan avatar di GCS menggunakan Laravel Storage
                    $disk = Storage::disk('gcs');
                    $disk->put($avatarPath, $picture);

                    // Dapatkan URL dari file yang diunggah
                    $avatarUrl = $disk->url($avatarPath);

                    // Buat instance ImageManager dengan GD driver
                    $manager = new ImageManager(new Driver());

                    // Baca gambar dari sistem file
                    $image = $manager->make($picture);

                    // Ubah ukuran gambar untuk membuat thumbnail
                    $image->resize(150, 150);

                    // Simpan thumbnail ke GCS
                    $avatarThumbnailPath = 'avatars/thumbnails/' . $uid . '.png';
                    $disk->put($avatarThumbnailPath, (string) $image->encode('png'));

                    // Dapatkan URL thumbnail
                    $avatarThumbnailUrl = $disk->url($avatarThumbnailPath);

                    $log['avatar_url'] = $avatarUrl;
                    $log['avatar_thumbnail_url'] = $avatarThumbnailUrl;

                    // Hapus file sementara setelah diproses
                    Storage::delete($this->picturePath);
                }

                $user = User::create([
                    'username' => $eventData['employeeNoString'],
                    'name' => $eventData['name'] ?? null,
                    'email' => $eventData['employeeNoString'] . '@ems.com',
                    'password' => Hash::make($password),
                    'password_string' => $password,
                    'avatar_url' => null,
                    'avatar_path' => null,
                    'avatar_thumbnail_url' => null,
                    'avatar_thumbnail_path' => null,
                    'status' => 'active',
                ]);

                $user->assignRole('Employee');
                $log['user_created'] = $eventData['name'] ?? null;
            }

            // Cek apakah employee sudah ada berdasarkan uid
            $employee = Employee::where('uid', $eventData['employeeNoString'])->first();
            if (!$employee) {
                $employee = Employee::create([
                    'uid' => $eventData['employeeNoString'],
                    'user_id' => $user->id
                ]);

                $log['employee_created'] = $eventData['employeeNoString'] ?? null;
            }

            // Cek apakah sudah ada record dengan serialNo yang sama
            $attendance = Attendance::where('uid', $eventData['serialNo'])
                ->where('machine_id', $machine->id)
                ->first();

            if (!$attendance) {
                // Simpan log absensi baru jika belum ada record dengan serialNo yang sama
                $attendance = Attendance::create([
                    'uid' => $eventData['serialNo'],
                    'employee_id' => $employee->id,
                    'machine_id' => $machine->id,
                    'attendance_method_id' => 1,
                    'site_id' => $site->id,
                    'type' => $eventType,
                    'timestamp' => $timestamp,
                    'longitude' => $site->longitude,
                    'latitude' => $site->latitude,
                ]);

                $log['attendance_id'] = 'Attendance ID ' . $attendance->id;
            } else {
                $log['attendance_exists'] = 'Attendance already exists for UID ' . $eventData['serialNo'];
            }

            DB::commit();

            $log['machine_id'] = $machine->id;
            $log['employee_id'] = $eventData['employeeNoString'];
            $log['timestamp'] = $timestamp;

            Log::info($log);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing AccessControllerEvent: ' . $e->getMessage());
            throw $e;
        }
    }
}
