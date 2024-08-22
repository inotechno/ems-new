<?php

namespace App\Livewire\Site;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class SiteList extends Component
{
    #[Reactive]
    public $sites;

    public function render()
    {
        return view('livewire.site.site-list');
    }
}
