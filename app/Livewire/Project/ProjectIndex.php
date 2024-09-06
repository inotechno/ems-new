<?php

namespace App\Livewire\Project;

use App\Livewire\BaseComponent;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProjectIndex extends BaseComponent
{
    use LivewireAlert, WithPagination;

    #[Url(except: '')]
    public $search = '';
    public $perPage = 10;
    public $status = '';

    protected $queryStrings = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshIndex' => '$refresh',
    ];

    public function resetFilter()
    {
        $this->search = '';
        $this->status = '';
        $this->perPage = 10;
    }

    public function render()
    {
        $projects = Project::with('employees.user', 'projectManager.user')->when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })->when($this->status, function ($query) {
            $query->where('status', $this->status);
        })->latest();

        if($this->authUser->can('view:project-all')) {
            $projects = $projects->paginate($this->perPage);
        }else if($this->authUser->hasRole('Project Manager')) {
            $projects = $projects->where('employee_id', $this->authUser->employee->id)->paginate($this->perPage);
        }else {
            $projects = $projects->whereHas('employees', function($query) {
                $query->where('employee_id', $this->authUser->employee->id);
            })->paginate($this->perPage);
        }

        return view('livewire.project.project-index', compact('projects'))->layout('layouts.app', ['title' => 'Project List']);
    }
}
