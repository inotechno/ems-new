<?php

namespace App\Livewire\EmailTemplateManager;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class EmailTemplateManagerList extends Component
{
    #[Reactive]
    public $templates;

    public function render()
    {
        return view('livewire.email-template-manager.email-template-manager-list');
    }
}
