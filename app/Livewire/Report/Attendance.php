<?php

namespace App\Livewire\Report;

use App\Models\Employee;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use DatePeriod;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\Attendance as AttendanceModel;

class Attendance extends Component
{
    use LivewireAlert;

    public $employees;
    public $selectedEmployees = [];
    public $startDate, $endDate, $countDays;

    public function mount()
    {
        $this->employees = Employee::with('user:id,name')->get(['id', 'user_id']);
    }

    #[On('change-input-form')]
    public function changeInputForm($param, $value)
    {
        $this->$param = $value;
    }

    public function preview()
    {
        try {
            $this->validate([
                'startDate' => 'required',
                'endDate' => 'required',
                'selectedEmployees' => 'required|array|min:1'
            ]);

            $this->dispatch('attendance-preview', employees: $this->selectedEmployees, startDate: $this->startDate, endDate: $this->endDate);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.attendance')->layout('layouts.app', ['title' => 'Report - Attendance']);
    }
}
