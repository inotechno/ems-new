<?php

namespace App\Livewire\Position;

use App\Models\Position;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PositionIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $department_id;
    public $showForm = true;
    public $departments;
    public $employees;

    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'department_id' => ['except' => ''],
    ];

    public function handleRefresh()
    {
        logger('Refreshing index');
        $this->alert('success', 'Refreshed successfully');
        $this->dispatch('$refresh');
    }

    public function changeStatusForm()
    {
        if ($this->showForm) {
            $this->showForm = false;
        } else {
            $this->showForm = true;
        }
    }

    public function resetFilter()
    {
        $this->department_id = "";
        $this->search = "";
        $this->dispatch('reset-select2');
        $this->resetPage();
    }

    #[On('change-status-form')]
    public function updateShowForm()
    {
        $this->showForm = true;
        $this->dispatch('collapse-form');
    }

    public function mount()
    {
        $this->departments = \App\Models\Department::with('site', 'supervisor')->get();
        $this->employees = \App\Models\Employee::with('user')->get();
    }

    public function render()
    {
        $positions = Position::with('employees.user', 'department.site')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
            ->orWhereHas('department', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            });
        })->when($this->department_id, function ($query) {
            $query->where('department_id', $this->department_id);
        })->paginate($this->perPage);

        return view('livewire.position.position-index', compact('positions'))->layout('layouts.app', ['title' => 'Position']);
    }
}
