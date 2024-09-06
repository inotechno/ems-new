<?php

namespace App\Livewire\Dashboard;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardIndex extends BaseComponent
{
    public $user;
    public $name;

    public function mount()
    {
        $this->user = $this->authUser;
        $this->name = $this->user->name;
    }
    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
