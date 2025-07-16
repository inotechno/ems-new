<?php

namespace App\Livewire\Role;

use App\Livewire\BaseComponent;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleForm extends BaseComponent
{
    use LivewireAlert;

    public $role;
    public $name;
    public $mode = 'create';
    public $permissions;
    public $selectedPermissions = [];
    public $groupedPermissions;

    public function mount($id = null)
    {
        if ($id) {
            $this->role = Role::find($id);
            $this->name = $this->role->name;
            $this->mode = 'edit';
            $this->selectedPermissions = $this->role->permissions()->pluck('name')->toArray();
        }

        $permissions = Permission::all()->pluck('name');
        $this->groupedPermissions = $permissions->groupBy(function ($item) {
            return explode(':', $item)[0];
        });
    }

    public function resetFormFields()
    {
        $this->name = null;
        $this->mode = 'create';
        $this->permissions = null;
        $this->selectedPermissions = [];
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'selectedPermissions' => 'required',
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

            $role->syncPermissions($this->selectedPermissions);

            $this->alert('success', 'role created successfully');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('create')
                ->log("{$this->authUser->name} telah membuat role");

            return redirect()->route('role.index');
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

            $this->role->syncPermissions($this->selectedPermissions);

            $this->alert('success', 'role updated successfully');

            activity()
                ->causedBy($this->authUser) // Pengguna yang melakukan login
                ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
                ->event('update')
                ->log("{$this->authUser->name} telah mengubah role");

            return redirect()->route('role.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.role.role-form')->layout('layouts.app', ['title' => 'Role Form']);
    }
}
