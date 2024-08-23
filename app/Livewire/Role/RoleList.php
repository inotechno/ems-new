<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class RoleList extends Component
{
    #[Reactive]
    public $roles;

    public function render()
    {
        return view('livewire.role.role-list');
    }
}
