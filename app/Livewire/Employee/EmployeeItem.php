<?php

namespace App\Livewire\Employee;

use Carbon\Carbon;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class EmployeeItem extends Component
{
    #[Reactive]
    public $employee;

    public $limitDisplay = 2;

    public function render()
    {
        $user = $this->employee->user;
        $roles = $user->roles;

        return view('livewire.employee.employee-item', [
            'position' => $this->employee->position->name ?? null,
            'user' => $user,
            'roles' => $roles
        ]);
    }
}
