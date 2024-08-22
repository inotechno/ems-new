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

    #[Reactive]
    public $department;
    public $limitDisplay = 5;

    public function getEmployeesProperty()
    {
        // Compute employees using a derived property
        return $this->department->positions->flatMap(function ($position) {
            return $position->employees;
        });
    }

    public function deleteConfirm()
    {
        $this->alert(
            'question',
            'Are you sure you want to delete this department?',
            [
                'toast' => false,
                'timer' => 3000,
                'position' => 'center',
                'showConfirmButton' => true,
                'showCancelButton' => true,
                'confirmButtonColor' => '#cc2626',
                'confirmButtonText' => 'Yes, Delete it!',
                'cancelButtonText' => 'No, Cancel!',
                'onConfirmed' => 'delete-department',
                'timerProgressBar' => true,
            ]
        );
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
