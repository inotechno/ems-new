<?php

namespace App\Livewire\Component;

use Livewire\Component;

class Modal extends Component
{
    public $modal_id = '';
    public $title = '';
    public $body = '';

    public function render()
    {
        return view('livewire.component.modal', [
            'modal_id' => $this->modal_id,
            'title' => $this->title,
            'body' => $this->body,
        ]);
    }
}
