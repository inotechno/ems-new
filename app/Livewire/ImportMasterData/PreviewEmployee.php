<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewEmployee extends Component
{
    public $employees;

    public function mount($employees)
    {
        $this->employees = $employees;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-employee');
    }
}
