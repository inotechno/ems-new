<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewPosition extends Component
{
    public $positions;

    public function mount($positions)
    {
        $this->positions = $positions;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-position');
    }
}
