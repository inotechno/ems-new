<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewRole extends Component
{
    public $role;

    public function mount($role)
    {
        $this->role = $role;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-role');
    }
}
