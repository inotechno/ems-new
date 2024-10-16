<?php

namespace App\Livewire\Department;

use App\Models\Department;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $site_id;
    public $showForm = true;
    public $sites, $employees;
    protected $listeners = [
        'refreshIndex' => 'handleRefresh',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'site_id' => ['except' => ''],
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
        $this->site_id = "";
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
        $this->sites = \App\Models\Site::get();
        $this->employees = \App\Models\Employee::with('user')->get();
    }

    public function render()
    {
        $departments = Department::with('site', 'supervisor.user', 'positions.employees.user')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->when($this->site_id, function ($query) {
            $query->where('site_id', $this->site_id);
        })->paginate($this->perPage);

        // dd($departments);
        return view('livewire.department.department-index', compact('departments'))->layout('layouts.app', ['title' => 'Department List']);
    }
}
