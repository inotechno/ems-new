<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class PositionForm extends Component
{
    use LivewireAlert;
    public $departments;
    public $position;
    public $name, $department_id;
    public $mode = 'create';

    public function mount($departments)
    {
        $this->departments = $departments;
    }

    public function resetFormFields()
    {
        $this->name = '';
        $this->department_id = '';
        $this->mode = 'create';
    }

    #[On('set-position')]
    public function getDataPosition($position_id)
    {
        $this->position = Position::find($position_id);
        $this->name = $this->position->name;
        $this->department_id = $this->position->department_id;

        $this->mode = 'edit';
        $this->dispatch('change-status-form');
    }

    public function save()
    {
        if($this->department_id == '') {
            $this->alert('error', 'Please select department');
            return;
        }

        $this->validate([
            'name' => 'required',
            'department_id' => 'required',
        ]);

        if ($this->mode == 'create') {
            $this->store();
        } else if ($this->mode == 'edit') {
            $this->update();
        }
    }

    public function store()
    {
        try {
            $position = Position::create([
                'name' => $this->name,
                'department_id' => $this->department_id,
            ]);

            $this->alert('success', 'Position created successfully');

            $this->resetFormFields();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->position->update([
                'name' => $this->name,
                'department_id' => $this->department_id,
            ]);

            $this->alert('success', 'Position updated successfully');
            $this->dispatch('refreshIndex');
            $this->resetFormFields();
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.position.position-form');
    }
}
