<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Models\Employee;
use App\Livewire\BaseComponent;
use App\Policies\EmployeePolicy;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProfileIndex extends BaseComponent
{
    use LivewireAlert;
    public $employee;

    public $user;
    public $projects;
    public $attendances;

    public $project_status = [];

    public $project_not_started = 0,
    $project_in_progress = 0,
    $project_completed = 0,
    $project_cancelled = 0,
    $project_on_hold = 0;

    public function mount()
    {
        $this->user = $this->authUser;
        $this->employee = Employee::with('user', 'position')->where('user_id', $this->user->id)->first();
        if ($this->employee) {
            $this->user = $this->employee->user;
            $this->projects = $this->employee->projects;
            $this->project_status = $this->setProjectStatus();
            $this->attendances = $this->employee->attendances;
        }

    }

    public function setProjectStatus()
    {
        $this->project_not_started = $this->projects->where('status', 'not_started')->count();
        $this->project_in_progress = $this->projects->where('status', 'in_progress')->count();
        $this->project_completed = $this->projects->where('status', 'completed')->count();
        $this->project_cancelled = $this->projects->where('status', 'cancelled')->count();
        $this->project_on_hold = $this->projects->where('status', 'on_hold')->count();

        $project_status = [
            'Completed' => ['count' => $this->project_completed, 'icon' => 'bx bx-check-circle'],
            'Cancelled' => ['count' => $this->project_cancelled, 'icon' => 'bx bx-x-circle'],
            'On Hold' => ['count' => $this->project_on_hold, 'icon' => 'bx bx-pause-circle'],
            'Not Started' => ['count' => $this->project_not_started, 'icon' => 'bx bx-hourglass'],
            'In Progress' => ['count' => $this->project_in_progress, 'icon' => 'bx bx-hourglass'],
        ];

        return $project_status;
    }

    public function render()
    {
        return view('livewire.profile.profile-index')->layout('layouts.app', ['title' => 'User Profile']);
    }
}
