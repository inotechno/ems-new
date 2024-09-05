<?php

namespace App\Livewire\Position;

use App\Models\Employee;
use App\Models\Position;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PositionModalAddEmployee extends Component
{
    use LivewireAlert;
    public $employees;
    public $position;
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
    public function showModal($position_id)
    {
        $this->position = Position::find($position_id);
        $this->resetFormFields();
        $this->dispatch('open-modal-add-employee');
    }

    public function store()
    {
        $this->validate([
            'employee_id.*' => 'required|exists:employees,id',
        ]);

        try {
            Employee::whereIn('id', $this->employee_id)->update(['position_id' => $this->position->id]);
            $this->alert('success', 'Successfully added employees');

            $this->resetFormFields();
            $this->dispatch('close-modal-add-employee');
            return redirect(route('position.index'));
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.position.position-modal-add-employee');
    }
}
