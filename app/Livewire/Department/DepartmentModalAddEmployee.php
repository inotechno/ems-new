<?php

namespace App\Livewire\Department;

use App\Models\Department;
use App\Models\Employee;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class DepartmentModalAddEmployee extends Component
{
    use LivewireAlert;
    public $employees;
    public $department;
    public $employee_id = [];

    public function mount()
    {
        $this->employees = Employee::with('user')->get();
    }

    public function resetFormFields()
    {
        $this->employee_id = [];
    }

    #[On('show-modal-add-employee')]
    public function showModal($department_id)
    {
        $this->department = Department::find($department_id);
        $this->resetFormFields();
        $this->dispatch('open-modal-add-employee');
    }

    public function store()
    {
        $this->validate([
            'employee_id.*' => 'required|exists:employees,id',
        ]);

        try {
            $this->department->employees()->syncWithoutDetaching($this->employee_id);
            $this->alert('success', 'Successfully added employees');

            $this->resetFormFields();
            $this->dispatch('close-modal-add-employee');
            return redirect(route('department.index'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.department.department-modal-add-employee');
    }
}
