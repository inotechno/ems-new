<?php

namespace App\Livewire\Machine;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class MachineList extends Component
{
    #[Reactive]
    public $machines;

    public function render()
    {
        // dd($this->machines);
        return view('livewire.machine.machine-list');
    }
}
