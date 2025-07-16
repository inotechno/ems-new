<?php

namespace App\Livewire\Component\Widget;

use App\Livewire\BaseComponent;
use App\Models\Employee;
use Livewire\Component;

class DashboardProfile extends BaseComponent
{
    public $name, $email, $avatar_url, $position, $totalEmployee;
    public function mount()
    {
        $this->name = $this->authUser->name;
        $this->email = $this->authUser->email;
        $this->avatar_url = $this->authUser->avatar_url;
        $this->position = $this->authUser->employee->position->name ?? '';
        $this->totalEmployee = Employee::count();
    }

        public function render()
    {
        return view('livewire.component.widget.dashboard-profile');
    }
}
