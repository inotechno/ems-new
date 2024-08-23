<?php

namespace App\Livewire\Role;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleForm extends Component
{

    use LivewireAlert;

    public $role;
    public $name;
    public $mode = 'create';

    public function resetFormFields()
    {
        $this->name = '';
        $this->mode = 'create';
    }

    #[On('set-role')]
    public function getDataRole($role_id)
    {
        $this->role = Role::find($role_id);
        $this->name = $this->role->name;

        $this->mode = 'edit';
        $this->dispatch('change-status-form');
    }

    public function save()
    {

        $this->validate([
            'name' => 'required',
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
            $role = role::create([
                'name' => $this->name,
            ]);

            $this->alert('success', 'role created successfully');

            $this->resetFormFields();
            $this->dispatch('refreshIndex');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    public function update()
    {
        try {
            $this->role->update([
                'name' => $this->name,
            ]);

            $this->alert('success', 'role updated successfully');
            $this->dispatch('refreshIndex');
            $this->resetFormFields();
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.role.role-form');
    }
}
