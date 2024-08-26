<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewMachine extends Component
{
    public $machines;

    public function mount($machines)
    {
        $this->machines = $machines;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-machine');
    }
}
