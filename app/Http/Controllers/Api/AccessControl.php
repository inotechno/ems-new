<?php

namespace App\Http\Controllers\Api;

use App\Events\AccessControlEvent;
use App\Jobs\HandleAccessControlEvent;
use App\Models\User;
use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Machine;
use App\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class AccessControl extends Controller
{
    public function index(Request $request)
    {
        $eventLog = json_decode($request->input('event_log'), true);
        AccessControlEvent::dispatch($eventLog);
        return response()->json(['status' => 'Event dispatched']);
    }

    // public function index(Request $request)
    // {
    //     // \Log::info($request->input('event_log'));
    //     // die;

    //     $log = array();

    //     // Tangkap data event log
    //     $eventLog = json_decode($request->input('event_log'), true);
    //     $ipAddress = $eventLog['ipAddress'];
    //     $log['ipAddress'] = $ipAddress;
    //     $eventData = $eventLog['AccessControllerEvent'];

    //     // Format timestamp dari event log
    //     $timestamp = Carbon::parse($eventLog['dateTime'])->format('Y-m-d H:i:s');

    //     $site = Site::find(1);
    //     $machine = Machine::where('ip_address', $ipAddress)->first();
    //     if ($machine === null) {
    //         return \Log::error('Machine with IP address ' . $ipAddress . ' not found');
    //     }
    //     // Tentukan apakah ini event masuk atau keluar berdasarkan IP address
    //     $eventType = $ipAddress === '192.168.20.202' ? 'out' : ($ipAddress === '192.168.20.201' ? 'in' : null);

    //     if (!$eventType) {
    //         return \Log::error('Invalid IP address');
    //     }

    //     DB::beginTransaction();
    //     try {
    //         if (empty($eventData['employeeNoString'])) {
    //             return \Log::error('Invalid employeeNoString, timestamp: ' . $timestamp . ' EventType: ' . $eventType);
    //         } else {
    //             // Cek apakah user sudah ada berdasarkan employeeNoString
    //             $user = User::where('username', $eventData['employeeNoString'])->first();

    //             if (!$user) {
    //                 $avatarUrl = null;
    //                 $avatarThumbnailUrl = null;
    //                 $avatarPath = null;
    //                 $avatarThumbnailPath = null;

    //                 $uid = Str::uuid();
    //                 if ($request->hasFile('Picture')) {
    //                     $picture = $request->file('Picture');
    //                     $avatarPath = 'avatars/' . $uid . '.' . $picture->getClientOriginalExtension();

    //                     // Store avatar in GCS using Laravel Storage
    //                     $disk = Storage::disk('gcs');
    //                     $disk->put($avatarPath, file_get_contents($picture));

    //                     // Get the URL of the uploaded file
    //                     $avatarUrl = $disk->url($avatarPath);

    //                     // Create ImageManager instance with GD driver
    //                     $manager = new ImageManager(new Driver());

    //                     // Read image from file system
    //                     $image = $manager->read($picture->getPathname());

    //                     // Resize image to create thumbnail
    //                     $image->scale(150, 150); // Resize to fit thumbnail dimensions

    //                     // Save the thumbnail to GCS
    //                     $avatarThumbnailPath = 'avatars/thumbnails/' . $uid . '.png';
    //                     $disk->put($avatarThumbnailPath, (string) $image->toPng());

    //                     // Get the URL of the thumbnail
    //                     $avatarThumbnailUrl = $disk->url($avatarThumbnailPath);

    //                     $log['avatar_url'] = $avatarUrl;
    //                     $log['avatar_thumbnail_url'] = $avatarThumbnailUrl;
    //                 }

    //                 $user = $this->insertUser($eventData);
    //                 $log['user_employee_created'] = $user->name ?? null;
    //             }

    //             // Cek apakah sudah ada record dengan serialNo yang sama
    //             $attendance = Attendance::where('uid', $eventData['serialNo'])
    //                 ->where('machine_id', $machine->id)
    //                 ->first();

    //             if (!$attendance) {
    //                 // Simpan log absensi baru jika belum ada record dengan serialNo yang sama
    //                 $attendance = Attendance::create([
    //                     'uid' => $eventData['serialNo'],
    //                     'employee_id' => $user->employee->id,
    //                     'machine_id' => $machine->id,
    //                     'attendance_method_id' => 1,
    //                     'site_id' => $site->id,
    //                     'type' => $eventType,
    //                     'timestamp' => $timestamp,
    //                     'longitude' => $site->longitude,
    //                     'latitude' => $site->latitude,
    //                 ]);

    //                 $log['attendance_id'] = 'Attendance ID ' . $attendance->id;
    //             } else {
    //                 $log['attendance_exists'] = 'Attendance already exists for UID ' . $eventData['serialNo'];
    //             }
    //         }

    //         DB::commit();

    //         $log['machine_id'] = $machine->id;
    //         $log['employee_id'] = $eventData['employeeNoString'];
    //         $log['timestamp'] = $timestamp;

    //         \Log::info($log);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         \Log::error('Error processing AccessControllerEvent: ' . $e->getMessage());
    //         throw $e;
    //     }
    // }
}
