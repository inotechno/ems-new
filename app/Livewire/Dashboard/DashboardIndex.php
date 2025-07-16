<?php

namespace App\Livewire\Dashboard;

use App\Livewire\BaseComponent;
use App\Models\AbsentRequest;
use App\Models\Attendance;
use App\Models\DailyReport;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardIndex extends BaseComponent
{
    public $user;
    public $name;

    public $totalDailyReport, $totalDayLeaveRequest, $totalVisit, $totalDayPresent, $totalAmountFinancialRequest, $totalDayAbsentRequest;

    public $totalDailyReportYesterday, $totalVisitYesterday, $totalPresentYesterday, $totalAbsentRequestYesterday, $totalLeaveRequestYesterday, $totalSickAsbentRequestYesterday;
    public $month, $year, $yesterday;

    public function mount()
    {
        $this->user = $this->authUser;
        $this->name = $this->user->name;
        $this->month = date('m');
        $this->year = date('Y');
        $this->yesterday = now()->subDay()->toDateString();

        $this->getYesterdayData();
        $this->getData();
    }

    public function getYesterdayData()
    {
        $this->totalDailyReportYesterday = $this->getTotalDailyReportYesterday();
        $this->totalVisitYesterday = $this->getTotalVisitYesterday();
        $this->totalPresentYesterday = $this->gettotalPresentYesterday();
        $this->totalAbsentRequestYesterday = $this->gettotalAbsentRequestYesterday();
        $this->totalLeaveRequestYesterday = $this->gettotalLeaveRequestYesterday();
        $this->totalSickAsbentRequestYesterday = $this->gettotalSickAsbentRequestYesterday();
    }

    public function getData()
    {
        $this->totalDailyReport = $this->getTotalDailyReport();
        $this->totalDayLeaveRequest = $this->gettotalDayLeaveRequest();
        $this->totalVisit = $this->getTotalVisit();

        $this->totalDayPresent = $this->gettotalDayPresent();
        $this->totalAmountFinancialRequest = number_format($this->gettotalAmountFinancialRequest() ?? 0);
        $this->totalDayAbsentRequest = $this->gettotalDayAbsentRequest();
    }

    public function getTotalDailyReportYesterday()
    {
        // Get total daily report yesterday from all employee
        return DailyReport::whereDate('date', $this->yesterday)->distinct('employee_id')->count();
    }

    public function getTotalVisitYesterday()
    {
        return Visit::whereDate('created_at', $this->yesterday)->distinct('employee_id')->count();
    }

    public function gettotalPresentYesterday()
    {
        return Attendance::whereDate('timestamp', $this->yesterday)
            ->distinct('employee_id')
            ->count();
    }

    public function gettotalAbsentRequestYesterday()
    {
        return AbsentRequest::where('is_approved', true)
            ->where('start_date', '<=', $this->yesterday)
            ->where('end_date', '>=', $this->yesterday)
            ->distinct('employee_id')
            ->count();
    }

    public function gettotalLeaveRequestYesterday()
    {
        return LeaveRequest::where('is_approved', true)
            ->where('start_date', '<=', $this->yesterday)
            ->where('end_date', '>=', $this->yesterday)
            ->distinct('employee_id')
            ->count();
    }

    public function gettotalSickAsbentRequestYesterday()
    {
        return AbsentRequest::where('is_approved', true)
            ->where('type_absent', 'sakit')
            ->where('start_date', '<=', $this->yesterday)
            ->where('end_date', '>=', $this->yesterday)
            ->distinct('employee_id')->count();
    }

    public function getTotalDailyReport()
    {
        return $this->authUser->employee->dailyReports()->whereMonth('date', $this->month)->whereYear('date', $this->year)->count();
    }

    public function gettotalDayLeaveRequest()
    {
        // Get total_days where is_approved = true
        return $this->authUser->employee->leaveRequests()->whereMonth('start_date', $this->month)->whereYear('start_date', $this->year)->where('is_approved', true)->sum('total_days');
    }

    public function getTotalVisit()
    {
        return $this->authUser->employee->visits()->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->count();
    }

    public function gettotalDayPresent()
    {
        // Get total attendance group by date timestamp
        return $this->authUser->employee->attendances()->selectRaw('DATE(timestamp) as date')->groupByRaw('DATE(timestamp)')->whereMonth('timestamp', $this->month)->whereYear('timestamp', $this->year)->get()->count();
    }

    public function gettotalAmountFinancialRequest()
    {
        // Get total amount where is_approved = true
        return $this->authUser->employee->financialRequests()->whereMonth('created_at', $this->month)->whereYear('created_at', $this->year)->where('is_approved', true)->sum('amount');
    }

    public function gettotalDayAbsentRequest()
    {
        return $this->authUser->employee->absentRequests()->where('is_approved', true)->whereMonth('start_date', $this->month)->whereYear('start_date', $this->year)->sum('total_days');
    }
    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
