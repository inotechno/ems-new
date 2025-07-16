<?php

namespace App\Livewire\Component;

use Livewire\Component;

class CardMini extends Component
{
    public $title, $value, $badge;

    public function mount($title, $value, $badge = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->badge = $badge;
    }

    public function render()
    {
        return view('livewire.component.card-mini');
    }
}
