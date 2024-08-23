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
        return view('livewire.employee.employee-item', [
            'positions' => $this->employee->positions->take($this->limitDisplay), 
            'user' => $this->employee->user
        ]);
    }
}
