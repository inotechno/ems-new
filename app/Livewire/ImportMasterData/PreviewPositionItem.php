<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewPositionItem extends Component
{
    public $position;
    public $is_old_data;

    public function mount($position)
    {
        $this->position = $position;
        $checkOldData = \App\Models\Position::where('id', $position['id'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-position-item');
    }
}
