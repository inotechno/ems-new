<?php

namespace App\Livewire\Report;

use App\Models\LeaveRequest;
use Illuminate\Support\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class LeaveRequestPreview extends Component
{
    use LivewireAlert;
    public $startDate;
    public $endDate;
    public $selectedEmployees;
    public $reports;

    #[On('leave-request-preview')]
    public function preview($employees, $startDate, $endDate)
    {
        $this->selectedEmployees = $employees;

        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

        // dd($this->startDate, $this->endDate);
        $this->countDays = daysBetween($this->startDate, $this->endDate) + 1;

        try {
            // Fetch absent requests
            $leaveRequests = LeaveRequest::with('employee.user')->select('employee_id', 'start_date', 'end_date', 'total_days', 'current_total_leave', 'total_leave_after_request', 'notes')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query){
                    $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                        ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
                })
                ->get();

            $this->reports = $leaveRequests;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.leave-request-preview');
    }
}
