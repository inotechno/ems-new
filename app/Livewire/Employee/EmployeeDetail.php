<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;

class EmployeeDetail extends Component
{
    public $employee;
    public $user;
    public $projects;
    public $attendances;

    public $project_status = [];

    public $totalDailyReport = 0;
    public $totalDayLeaveRequest = 0;
    public $totalVisit = 0;

    public $totalDayPresent = 0;
    public $totalAmountFinancialRequest = 0;
    public $totalDayAbsentRequest = 0;

    public $project_not_started = 0,
        $project_in_progress = 0,
        $project_completed = 0,
        $project_cancelled = 0,
        $project_on_hold = 0;

    public $month, $year;

    public function mount($id)
    {
        $this->month = date('m');
        $this->year = date('Y');

        $this->employee = Employee::with('user', 'position')->where('id', $id)->first();
        $this->user = $this->employee->user;
        $this->projects = $this->employee->projects;
        $this->project_status = $this->setProjectStatus();
        $this->attendances = $this->employee->attendances;

        $this->totalDailyReport = $this->getTotalDailyReport();
        $this->totalDayLeaveRequest = $this->gettotalDayLeaveRequest();
        $this->totalVisit = $this->getTotalVisit();

        $this->totalDayPresent = $this->gettotalDayPresent();
        $this->totalAmountFinancialRequest = number_format($this->gettotalAmountFinancialRequest() ?? 0);
        $this->totalDayAbsentRequest = $this->gettotalDayAbsentRequest();
    }

    public function setProjectStatus()
    {
        $this->project_not_started = $this->projects->where('status', 'not_started')->count();
        $this->project_in_progress = $this->projects->where('status', 'in_progress')->count();
        $this->project_completed = $this->projects->where('status', 'completed')->count();
        $this->project_cancelled = $this->projects->where('status', 'cancelled')->count();
        $this->project_on_hold = $this->projects->where('status', 'on_hold')->count();

        $project_status = [
            'Completed' => ['count' => $this->project_completed, 'icon' => 'bx bx-check-circle'],
            'Cancelled' => ['count' => $this->project_cancelled, 'icon' => 'bx bx-x-circle'],
            'On Hold' => ['count' => $this->project_on_hold, 'icon' => 'bx bx-pause-circle'],
            'Not Started' => ['count' => $this->project_not_started, 'icon' => 'bx bx-hourglass'],
            'In Progress' => ['count' => $this->project_in_progress, 'icon' => 'bx bx-hourglass'],
        ];

        return $project_status;
    }

    public function getTotalDailyReport()
    {
        return $this->user->employee->dailyReports()->whereMonth('date', $this->month)->whereYear('date', $this->year)->count();
    }

    public function gettotalDayLeaveRequest()
    {
        // Get total_days where is_approved = true
        return $this->user->employee->leaveRequests()->whereMonth('start_date', $this->month)->whereYear('start_date', $this->year)->where('is_approved', true)->sum('total_days');
    }

    public function getTotalVisit()
    {
        return $this->user->employee->visits()->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->count();
    }

    public function gettotalDayPresent()
    {
        // Get total attendance group by date timestamp
        return $this->user->employee->attendances()->selectRaw('DATE(timestamp) as date')->groupByRaw('DATE(timestamp)')->whereMonth('timestamp', $this->month)->whereYear('timestamp', $this->year)->get()->count();
    }

    public function gettotalAmountFinancialRequest()
    {
        // Get total amount where is_approved = true
        return $this->user->employee->financialRequests()->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->where('is_approved', true)->sum('amount');
    }

    public function gettotalDayAbsentRequest()
    {
        return $this->user->employee->absentRequests()->where('is_approved', true)->whereMonth('start_date', $this->month)->whereYear('start_date', $this->year)->sum('total_days');
    }

    public function render()
    {
        return view('livewire.employee.employee-detail')->layout('layouts.app', ['title' => 'Employee Detail']);
    }
}
