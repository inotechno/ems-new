<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Livewire\Component;

class DepartmentDetail extends Component
{
    public $department;
    public $site;
    public $positions;
    public $employees;
    public $supervisor;

    public function mount($id)
    {
        $this->department = Department::with('site', 'positions.employees')->where('id', $id)->first();
        // dd($this->department);
        $this->site = $this->department->site;
        $this->positions = $this->department->positions;
        $this->employees = $this->getEmployeesProperty();
        $this->supervisor = $this->department->supervisor ?? null;
    }

    public function getEmployeesProperty()
    {
        // Compute employees using a derived property
        return $this->positions->flatMap(function ($position) {
            return $position->employees;
        });
    }

    public function render()
    {
        return view('livewire.department.department-detail')->layout('layouts.app', ['title' => 'Department Detail']);
    }
}
