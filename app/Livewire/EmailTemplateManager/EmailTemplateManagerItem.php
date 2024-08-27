<?php

namespace App\Livewire\EmailTemplateManager;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class EmailTemplateManagerItem extends Component
{
    #[Reactive]
    public $template;

    public function render()
    {
        return view('livewire.email-template-manager.email-template-manager-item');
    }
}
