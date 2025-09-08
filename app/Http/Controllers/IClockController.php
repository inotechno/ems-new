<?php

namespace App\Http\Controllers;

use App\Jobs\AttendanceSyncJob;
use App\Models\Employee;
use App\Models\Machine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IClockController extends Controller
{
    public function __invoke(Request $request)
    {
    }

    public function handshake(Request $request)
    {
        $r = "GET OPTION FROM: {$request->input('SN')}\r\n" .
            "Stamp=9999\r\n" .
            "OpStamp=" . time() . "\r\n" .
            "ErrorDelay=60\r\n" .
            "Delay=30\r\n" .
            "ResLogDay=18250\r\n" .
            "ResLogDelCount=10000\r\n" .
            "ResLogCount=50000\r\n" .
            "TransTimes=00:00;14:05\r\n" .
            "TransInterval=1\r\n" .
            "TransFlag=1111000000\r\n" .
            //  "TimeZone=7\r\n" .
            "Realtime=1\r\n" .
            "Encrypt=0";

        \Log::info('Handshake', $request->all());
        return $r;
    }

    public function test(Request $request)
    {
        \Log::info('Test', $request->all());
    }

    public function receiveRecords(Request $request)
    {
        \Log::info('Receive Records', $request->all());
        $siteId = 1;
        $attendance_method_id = 1;

        try {
            $arr = preg_split('/\\r\\n|\\r|,|\\n/', $request->getContent());
            $machine = Machine::where('ip_address', $request->ip())->first();
            $tot = 0;

            //operation log
            if ($request->input('table') == "OPERLOG") {
                foreach ($arr as $rey) {
                    if (isset($rey)) {
                        $tot++;
                    }
                }

                \Log::info('Operation Log', $request->all());
                return "OK: " . $tot;
            }

            //attendance
            foreach ($arr as $rey) {
                if (empty($rey)) {
                    continue;
                }

                $late = false;
                $diff_late = null;

                $data = explode("\t", $rey);

                $time = date('H:i:s', strtotime($data[1]));

                $employee = $this->getEmployee($data[0]);

                $email = '';
                $name = '';
                $whatsapp_number = '';

                $absenTime = Carbon::parse($request->timestamp)->timestamp;
                $date = Carbon::parse($request->timestamp)->format('Y-m-d');
                $startTime = Carbon::parse("$date 08:30:00")->timestamp;
                $endTime = Carbon::parse("$date 10:00:00")->timestamp;
                \Log::info('Absen Time', [$absenTime, $startTime, $endTime]);

                if ($absenTime > $startTime && $absenTime <= $endTime) {
                    $late = true;
                    $diffSeconds = $absenTime - $startTime; // Selisih dalam detik

                    $hours = floor($diffSeconds / 3600); // Konversi ke jam
                    $minutes = floor(($diffSeconds % 3600) / 60); // Sisa detik dikonversi ke menit
                    $seconds = $diffSeconds % 60; // Sisa detik

                    // Buat format waktu yang lebih fleksibel
                    $diff_late = [];
                    if ($hours > 0)
                        $diff_late[] = "$hours Jam";
                    if ($minutes > 0)
                        $diff_late[] = "$minutes Menit";
                    if ($seconds > 0)
                        $diff_late[] = "$seconds Detik";

                    $diff_late = implode(' ', $diff_late);
                }

                if ($employee != null) {
                    $email = $employee->user->email;
                    $name = $employee->user->name;
                    $whatsapp_number = $employee->whatsapp_number;
                } else {

                    $newUser = User::updateOrCreate([
                        'username' => $data[0]
                    ], [
                        'name' => $data[0],
                        'password' => bcrypt($data[0])
                    ]);

                    $newUser->assignRole('Employee');

                    $employee = Employee::updateOrCreate([
                        'id' => $data[0]
                    ], [
                        'user_id' => $newUser->id,
                    ]);

                    $email = $newUser->email;
                    $name = $newUser->name;
                }

                $attendanceData[] = [
                    'uid' => $data[0] . date('dHi'),
                    'employee_id' => $data[0],
                    'machine_id' => $machine->id ?? null,
                    'timestamp' => $data[1],
                    'attendance_method_id' => $attendance_method_id,
                    'site_id' => $siteId,
                    'longitude' => '106.798818',
                    'latitude' => '-6.263122',
                    'email' => $email,
                    'name' => $name,
                    'whatsapp_number' => $whatsapp_number,
                    'late' => $late,
                    'diff_late' => $diff_late
                ];

                activity()->log('Record Attendance: ' . $data[0]);

                AttendanceSyncJob::dispatch($attendanceData);
                $tot++;

                \Log::info('Attendance Data', $attendanceData);
            }

            \Log::info('Receive Records', $request->all());
            return "OK: " . $tot;
        } catch (Throwable $e) {
            \Log::error('Error', $e->getMessage());
            return "ERROR: " . $tot . "\n";
        }
    }

    public function getrequest(Request $request)
    {
        // \Log::info('Get Request', $request->all());
        return "OK";
    }

    public function testAttendance(Request $request)
    {
        $late = false;
        $diff_late = null;

        $absenTime = Carbon::parse($request->timestamp)->timestamp;
        $date = Carbon::parse($request->timestamp)->format('Y-m-d');
        $startTime = Carbon::parse("$date 08:30:00")->timestamp;
        $endTime = Carbon::parse("$date 10:00:00")->timestamp;
        \Log::info('Absen Time', [$absenTime, $startTime, $endTime]);

        if ($absenTime > $startTime && $absenTime <= $endTime) {
            $late = true;
            $diffSeconds = $absenTime - $startTime; // Selisih dalam detik

            $hours = floor($diffSeconds / 3600); // Konversi ke jam
            $minutes = floor(($diffSeconds % 3600) / 60); // Sisa detik dikonversi ke menit
            $seconds = $diffSeconds % 60; // Sisa detik

            // Buat format waktu yang lebih fleksibel
            $diff_late = [];
            if ($hours > 0)
                $diff_late[] = "$hours Jam";
            if ($minutes > 0)
                $diff_late[] = "$minutes Menit";
            if ($seconds > 0)
                $diff_late[] = "$seconds Detik";

            $diff_late = implode(' ', $diff_late);
        }

        $attendanceData[] = [
            'uid' => date('dHi') . '000',
            'employee_id' => 20221224,
            'state' => 2,
            'timestamp' => $request->timestamp,
            'type' => 1,
            'site_id' => 80,
            'event_id' => 3,
            'longitude' => '106.798818',
            'latitude' => '-6.263122',
            'email' => 'achmad.fatoni@mindotek.com',
            'name' => 'Achmad Fatoni',
            'whatsapp_number' => '6289676490971',
            'late' => $late,
            'diff_late' => $diff_late
        ];

        AttendanceSyncJob::dispatch($attendanceData);
        \Log::info('Attendance Data: ' . json_encode($attendanceData));
    }

    protected function getEmployee($id)
    {
        return Employee::with('user')->find($id) ?? null;
    }
}
