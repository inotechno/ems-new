<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Str;
use App\Models\User;

class EmployeeForm extends Component
{
    use LivewireAlert;
    public $employee;
    public $roles;

    public $name, $username, $email, $password, $role;
    public $user;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->roles = Role::all();
        if ($id) {
            $this->employee = Employee::find($id);
            $this->user = $this->employee->user;

            if ($this->user) {
                $this->name = $this->user->name;
                $this->username = $this->user->username;
                $this->email = $this->user->email;
                $this->role = $this->user()->roles()->first()->id;
                $this->type = 'update';
            }
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . ($this->user->id ?? 'NULL'),
            'email' => 'required|email|max:255|unique:users,email,' . ($this->user->id ?? 'NULL'),
            'role' => 'required|exists:roles,name',
        ]);

        $this->password = Str::random(8);

        if ($this->type == 'create') {
            $user = User::create([
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'password_string' => $this->password,
            ]);

            $user->employee()->create([
                'id' => rand(20240101, 20241231),
                'leave_remaining' => 0,
            ]);

            $user->assignRole($this->role);
        } else {
            $this->employee->user->update([
                'username' => $this->username,
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password ? Hash::make($this->password) : $this->employee->user->password,
            ]);

            $this->employee->user->assignRole($this->role);
        }

        $this->alert('success', 'Employee ' . $this->type . ' successfully');
        return redirect()->route('employee.index');
    }

    public function render()
    {
        return view('livewire.employee.employee-form')->layout('layouts.app', ['title' => 'Employee']);
    }
}
