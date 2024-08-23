<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class EmployeeList extends Component
{
    #[Reactive]

    public $employees;
    public function render()
    {
        return view('livewire.employee.employee-list');
    }
}
