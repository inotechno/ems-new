<?php

namespace App\Livewire\Site;

use App\Models\Site;
use Livewire\Component;

class SiteDetail extends Component
{
    public $site;
    public $departments;
    public $positions;
    public $employees;

    public function mount($uid)
    {
        $this->site = Site::with('departments.positions.employees')->where('uid', $uid)->first();

        // Ensure $this->departments is a collection or null
        $this->departments = $this->site ? $this->site->departments : collect(); // Default to an empty collection if null

        // Flatten all positions from departments
        $this->positions = $this->departments->flatMap(function ($department) {
            return $department->positions;
        });

        // Flatten all employees from positions
        $this->employees = $this->positions->flatMap(function ($position) {
            return $position->employees;
        });
    }

    public function render()
    {
        return view('livewire.site.site-detail')->layout('layouts.app', ['title' => $this->site->name]);
    }
}
