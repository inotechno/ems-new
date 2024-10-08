<?php

namespace App\Livewire\Component\Page;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Header extends BaseComponent
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
        return view('livewire.component.page.header');
    }
}
