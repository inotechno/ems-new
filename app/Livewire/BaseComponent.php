<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BaseComponent extends Component
{
    public $authUser;

    public function boot()
    {
        $this->authUser = Auth::user();
    }

}
