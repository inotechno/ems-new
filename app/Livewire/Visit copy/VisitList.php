<?php

namespace App\Livewire\Visit;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class VisitList extends Component
{
    #[Reactive]
    public $visits;

    public function render()
    {
        return view('livewire.visit.visit-list');
    }
}
