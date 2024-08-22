<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentDetail extends Component
{
    public $department;
    public $site;
    public $employees;
    public $supervisor;

    public function mount($id)
    {
        $this->department = Department::with('site', 'employees', 'supervisor', 'employees.user')->where('id', $id)->first();
        $this->site = $this->department->site;
        $this->employees = $this->department->employees;
        $this->supervisor = $this->department->supervisor;
    }

    public function render()
    {
        return view('livewire.department.department-detail')->layout('layouts.app', ['title' => 'Department Detail']);
    }
}
