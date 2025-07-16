<?php

namespace App\Livewire\Component\Widget;

use App\Helpers\HolidayHelper;
use App\Livewire\BaseComponent;
use App\Models\AbsentRequest;
use App\Models\AttendanceAnalytic;
use App\Models\LeaveRequest;
use Illuminate\Support\Carbon;

class WorkingDayAnalytic extends BaseComponent
{
    public $total_working_days;
    public $total_present_days;
    public $total_absent_days;
    public $total_leave_days;

    public $percentage_present;
    public $percentage_absent;
    public $percentage_leave;
    public $join_date;


    public function mount()
    {
        $this->join_date = $this->authUser->employee->join_date;
        $this->total_working_days = HolidayHelper::getWorkingDays($this->join_date, Carbon::now()->format('Y-m-d'));

        $presents = AttendanceAnalytic::where('employee_id', $this->authUser->employee->id)
            ->whereBetween('date', [
                $this->join_date,
                Carbon::now()
                    ->format('Y-m-d')
            ])->distinct('date')->count();
        $this->total_present_days = $presents;

        $absents = AbsentRequest::selectRaw('start_date, sum(total_days) as total_absents')
            ->where('employee_id', $this->authUser->employee->id)
            ->where('is_approved', true)
            ->whereDate('start_date', '>=', $this->join_date)
            ->whereDate('end_date', '<=', Carbon::now()->format('Y-m-d'))
            ->groupBy('start_date')
            ->get()->sum('total_absents');
        $this->total_absent_days = $absents;

        $leaves = LeaveRequest::selectRaw('start_date, sum(total_days) as total_leaves')
            ->where('employee_id', $this->authUser->employee->id)
            ->where('is_approved', true)
            ->whereBetween('start_date', [
                $this->join_date,
                Carbon::now()
                    ->format('Y-m-d')
            ])->groupBy('start_date')
            ->get()->sum('total_leaves');
        $this->total_leave_days = $leaves;

        $this->percentage_present = round(($this->total_present_days / $this->total_working_days) * 100, 2);
        $this->percentage_absent = round(($this->total_absent_days / $this->total_working_days) * 100, 2);
        $this->percentage_leave = round(($this->total_leave_days / $this->total_working_days) * 100, 2);
    }

    public function render()
    {
        return view('livewire.component.widget.working-day-analytic');
    }
}
