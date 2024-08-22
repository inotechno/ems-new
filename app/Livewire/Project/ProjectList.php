<?php

namespace App\Livewire\Project;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class ProjectList extends Component
{
    #[Reactive]
    public $projects;

    public function render()
    {
        return view('livewire.project.project-list');
    }
}
