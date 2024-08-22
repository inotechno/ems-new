<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\AccessControlEvent;
use App\Models\Site;
use App\Models\Machine;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HandleAccessControlEvent
{
    public function handle(AccessControlEvent $event)
    {
        $eventLog = $event->eventLog;

        $log = [];
        $ipAddress = $eventLog['ipAddress'];
        $log['ipAddress'] = $ipAddress;
        $eventData = $eventLog['AccessControllerEvent'];
        $timestamp = Carbon::parse($eventLog['dateTime'])->format('Y-m-d H:i:s');

        $site = Site::find(1);
        $machine = Machine::where('ip_address', $ipAddress)->first();
        if ($machine === null) {
            Log::error('Machine with IP address ' . $ipAddress . ' not found');
            return;
        }

        $eventType = $ipAddress === '192.168.20.202' ? 'out' : ($ipAddress === '192.168.20.201' ? 'in' : null);

        if (!$eventType) {
            Log::error('Invalid IP address');
            return;
        }

        DB::beginTransaction();
        try {
            if (empty($eventData['employeeNoString'])) {
                Log::error('Invalid employeeNoString, timestamp: ' . $timestamp . ' EventType: ' . $eventType);
                return;
            }

            $user = User::where('username', $eventData['employeeNoString'])->first();
            if (!$user) {
                $user = $this->insertUser($eventData);
                $log['user_employee_created'] = $user->name ?? null;
            }

            $attendance = Attendance::where('uid', $eventData['serialNo'])
                ->where('machine_id', $machine->id)
                ->first();

            if (!$attendance) {
                $attendance = Attendance::create([
                    'uid' => $eventData['serialNo'],
                    'employee_id' => $user->employee->id,
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

    private function insertUser($eventData)
    {
        $password = Str::random(8);
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
            'status' => 1,
        ]);

        $user->assignRole('Employee');
        $user->employee()->create([
            'id' => $eventData['employeeNoString'],
            'user_id' => $user->id
        ]);

        return $user;
    }
}
