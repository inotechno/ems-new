<?php

namespace App\Livewire\Component\Page;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropdownRoles extends Component
{
    public $roles;

    public function render()
    {
        $this->roles = Auth::user()->roles;
        return view('livewire.component.page.dropdown-roles');
    }
}
