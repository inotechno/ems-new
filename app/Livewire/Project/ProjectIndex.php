<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Jantinnerezo\LivewireAlert\LivewireAlert;   
use Livewire\Component;
use Livewire\WithPagination;
use URL;

class ProjectIndex extends Component
{
    use LivewireAlert, WithPagination;

    #[URL(except: '')]

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
        })->latest()->paginate($this->perPage);

        return view('livewire.project.project-index', compact('projects'))->layout('layouts.app', ['title' => 'Project List']);
    }
}
