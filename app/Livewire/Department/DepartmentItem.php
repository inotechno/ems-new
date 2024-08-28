<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DepartmentItem extends Component
{
    use LivewireAlert;


    public $department;
    public $limitDisplay = 5;

    public function mount(Department $department)
    {
        $this->department = $department;
    }

    public function getEmployeesProperty()
    {
        // Compute employees using a derived property
        return $this->department->positions->flatMap(function ($position) {
            return $position->employees;
        });
    }

    public function deleteConfirm()
    {
        $this->alert('warning', 'Are you sure you want to delete this department?', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,

            'showConfirmButton' => true,
            'confirmButtonColor' => '#DD6B55',
            'confirmButtonText' => 'Yes, Delete',
            'cancelButtonText' => 'No',
            'onConfirmed' => 'delete-department',
            'showCancelButton' => true,

            'allowOutsideClick' => false,
            'allowEnterKey' => true,
            'allowEscapeKey' => false,
            'stopKeydownPropagation' => false,
        ]);
    }

    #[On('delete-department')]
    public function delete()
    {
        $this->department->delete();
        $this->alert('success', 'Department deleted successfully');
        $this->dispatch('refreshIndex');
    }

    public function render()
    {
        return view('livewire.department.department-item', [
            'employees' => $this->getEmployeesProperty()->take($this->limitDisplay),
            'moreCount' => $this->getEmployeesProperty()->count() - $this->limitDisplay,
            'site' => $this->department->site,  // Make sure this is available
        ]);
    }
}
