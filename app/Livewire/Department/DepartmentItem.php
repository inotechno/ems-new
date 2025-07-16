<?php

namespace App\Livewire\Department;

use App\Livewire\BaseComponent;
use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class DepartmentItem extends BaseComponent
{
    use LivewireAlert;

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

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

        activity()
            ->causedBy($this->authUser) // Pengguna yang melakukan login
            ->withProperties(['ip' => request()->ip()]) // Menyimpan alamat IP
            ->event('delete')
            ->log("{$this->authUser->name} telah menghapus department");

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
