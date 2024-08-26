<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewDepartment extends Component
{
    public $departments;

    public function mount($departments)
    {
        $this->departments = $departments;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-department');
    }
}
