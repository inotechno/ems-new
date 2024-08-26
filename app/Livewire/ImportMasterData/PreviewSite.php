<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewSite extends Component
{
    public $sites;

    public function mount($sites)
    {
        $this->sites = $sites;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-site');
    }
}
