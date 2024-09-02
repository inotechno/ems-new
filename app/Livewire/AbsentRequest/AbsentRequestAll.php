<?php

namespace App\Livewire\AbsentRequest;

use Livewire\Component;

class AbsentRequestAll extends Component
{
    public function render()
    {
        return view('livewire.absent-request.absent-request-all')->layout('layouts.app', ['title' => 'Absent Request All']);
    }
}
