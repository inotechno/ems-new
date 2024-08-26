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
        // $roles = $user->roles;

        return view('livewire.employee.employee-item', [
            'positions' => $this->employee->positions->take($this->limitDisplay),
            'user' => $user,
            'roles' => $user->roles
        ]);
    }
}
