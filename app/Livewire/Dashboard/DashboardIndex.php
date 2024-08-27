<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $user;
    public $name;

    public function mount()
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
    }
    public function render()
    {
        return view('livewire.dashboard.dashboard-index')->layout('layouts.app', ['title' => 'Dashboard']);
    }
}
