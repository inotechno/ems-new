<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewMachineItem extends Component
{
    public $machine;
    public $is_old_data;

    public function mount($machine)
    {
        $this->machine = $machine;
        $checkOldData = \App\Models\Machine::where('id', $machine['id'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-machine-item');
    }
}
