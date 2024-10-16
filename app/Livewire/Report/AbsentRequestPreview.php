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

class AbsentRequestPreview extends Component
{
    use LivewireAlert;
    public $startDate;
    public $endDate;
    public $selectedEmployees;
    public $reports;

    #[On('absent-request-preview')]
    public function preview($employees, $startDate, $endDate)
    {
        $this->selectedEmployees = $employees;

        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();

        // dd($this->startDate, $this->endDate);
        $this->countDays = daysBetween($this->startDate, $this->endDate) + 1;

        try {
            // Fetch absent requests
            $absentRequests = AbsentRequest::with('employee.user')->select('employee_id', 'start_date', 'end_date', 'type_absent', 'notes')
                ->whereIn('employee_id', $this->selectedEmployees)
                ->where('is_approved', true)
                ->where(function ($query){
                    $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                        ->orWhereBetween('end_date', [$this->startDate, $this->endDate]);
                })
                ->get();

            $this->reports = $absentRequests;
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.absent-request-preview');
    }
}
