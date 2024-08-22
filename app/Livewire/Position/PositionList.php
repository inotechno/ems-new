<?php

namespace App\Livewire\Position;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class PositionList extends Component
{
    #[Reactive]
    public $positions;

    public function render()
    {
        return view('livewire.position.position-list');
    }
}
