<?php

namespace App\Livewire\Report;

use App\Models\AbsentRequest;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use DatePeriod;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AttendancePreview extends Component
{
    use LivewireAlert;
    public $startDate;
    public $endDate;
    public $selectedEmployees;
    public $countDays;
    public $reports;

    #[On('attendance-preview')]
    public function preview($employees, $startDate, $endDate)
    {
        $this->selectedEmployees = $employees;

        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

        // dd($this->startDate, $this->endDate);
        $this->countDays = daysBetween($this->startDate, $this->endDate) + 1;

        try {

            // dd($this->startDate, $this->endDate, $this->startDate, $this->endDate);
            // Eager load semua data yang diperlukan dalam satu query
            $employees = Employee::with(['user:id,name'])
                ->whereIn('id', $this->selectedEmployees)
                ->get(['id', 'user_id']);

            // Fetch semua attendance data dalam satu query
            $attendances = Attendance::select('employee_id', 'timestamp')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->whereBetween('timestamp', [$this->startDate, $this->endDate])
                ->orderBy('timestamp')
                ->get()
                ->groupBy('employee_id');

            // Fetch leave requests
            $leaveRequests = LeaveRequest::select('employee_id', 'start_date', 'end_date')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query) {
                    $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                        ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
                })
                ->get();

            // Fetch absent requests
            $absentRequests = AbsentRequest::select('employee_id', 'start_date', 'end_date')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query){
                    $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                        ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
                })
                ->get();

            $dateRange = new DatePeriod(
                Carbon::parse($this->startDate),
                CarbonInterval::day(),
                Carbon::parse($this->endDate)
            );

            // dd($dateRange);
            $this->reports = collect();

            foreach ($employees as $employee) {
                $employeeAttendances = $attendances->get($employee->id, collect())
                    ->groupBy(function($attendance) {
                        return Carbon::parse($attendance->timestamp)->format('Y-m-d');
                    });

                // Buat array untuk menyimpan periode cuti
                $leaveDates = [];
                foreach ($leaveRequests->where('employee_id', $employee->id) as $leave) {
                    $period = CarbonPeriod::create($leave->start_date, $leave->end_date);
                    foreach ($period as $date) {
                        $leaveDates[$date->format('Y-m-d')] = 'L';
                    }
                }

                // Buat array untuk menyimpan periode izin
                $absentDates = [];
                foreach ($absentRequests->where('employee_id', $employee->id) as $absent) {
                    $period = CarbonPeriod::create($absent->start_date, $absent->end_date);
                    foreach ($period as $date) {
                        $absentDates[$date->format('Y-m-d')] = 'A';
                    }
                }

                $employeeReport = [];

                foreach ($dateRange as $date) {
                    $dateStr = $date->format('Y-m-d');
                    $dayAttendances = $employeeAttendances->get($dateStr, collect());

                    // Cek apakah ada cuti atau izin pada tanggal tersebut
                    if (isset($leaveDates[$dateStr])) {
                        $timeRange = 'L';
                    } elseif (isset($absentDates[$dateStr])) {
                        $timeRange = 'A';
                    } elseif ($dayAttendances->isNotEmpty()) {
                        $firstAttendance = $dayAttendances->first();
                        $lastAttendance = $dayAttendances->last();

                        $timeRange = Carbon::parse($firstAttendance->timestamp)->format('H:i') .
                                    '-' .
                                    Carbon::parse($lastAttendance->timestamp)->format('H:i');
                    } else {
                        $timeRange = '-';
                    }

                    $employeeReport[$dateStr] = $timeRange;
                }

                $this->reports->push([
                    'employee_id' => $employee->id,
                    'name' => $employee->user->name,
                    'attendance_data' => $employeeReport
                ]);
            }

        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.attendance-preview', [
            'dateRange' => $this->startDate && $this->endDate ? new DatePeriod(
                Carbon::parse($this->startDate),
                CarbonInterval::day(),
                Carbon::parse($this->endDate)
            ) : collect()
        ]);
    }
}
