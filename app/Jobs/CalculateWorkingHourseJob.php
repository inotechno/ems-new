<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\AttendanceAnalytic;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class CalculateWorkingHourseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employeeId;
    protected $date;

    /**
     * Create a new job instance.
     */
    public function __construct($employeeId, $date)
    {
        $this->employeeId = $employeeId;
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $attendances = Attendance::selectRaw('employee_id, DATE(timestamp) as date, MIN(timestamp) as check_in, MAX(timestamp) as check_out')
            ->whereDate('timestamp', $this->date)
            ->where('employee_id', $this->employeeId)
            ->groupBy('employee_id', 'date')
            ->get();

        foreach ($attendances as $attendance) {
            $checkInTimestamp = new \DateTime($attendance->check_in);
            $checkOutTimestamp = new \DateTime($attendance->check_out);

            $workingHours = $checkOutTimestamp->diff($checkInTimestamp)->format('%H:%I:%S');

            AttendanceAnalytic::updateOrCreate(
                [
                    'employee_id' => $attendance->employee_id,
                    'date' => $attendance->date,
                ],
                [
                    'check_in' => Carbon::parse($attendance->check_in)->format('H:i:s'),
                    'check_out' => Carbon::parse($attendance->check_out)->format('H:i:s'),
                    'working_hourse' => $workingHours,
                ]
            );

            \Log::info('Calculate working hourse for employee ' . $attendance->employee_id . ' on ' . $attendance->date. ': ' . $workingHours);
        }
    }
}
