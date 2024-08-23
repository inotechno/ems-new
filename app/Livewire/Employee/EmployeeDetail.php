<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;

class EmployeeDetail extends Component
{
    public $employees;

    public function mount($id)
    {
        $this->employees = Employee::with('user', 'positions')->where('id', $id)->first();
    }

    public function render()
    {
        return view('livewire.employee.employee-detail')->layout('layouts.app', ['title' => 'Employee Detail']);
    }
}
