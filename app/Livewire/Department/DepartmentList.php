<?php

namespace App\Livewire\Department;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class DepartmentList extends Component
{
    #[Reactive]
    public $departments;

    public function render()
    {
        return view('livewire.department.department-list');
    }
}
