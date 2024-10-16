<?php

namespace App\Livewire\Report;

use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class AbsentRequest extends Component
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

            $this->dispatch('absent-request-preview', employees: $this->selectedEmployees, startDate: $this->startDate, endDate: $this->endDate);
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.report.absent-request')->layout('layouts.app', ['title' => 'Absent Request']);
    }
}
