<?php

namespace App\Livewire\Component\Page;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DropdownRoles extends BaseComponent
{
    public $roles;

    public function render()
    {
        $this->roles = $this->authUser->roles;
        return view('livewire.component.page.dropdown-roles');
    }
}
