<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewDepartmentItem extends Component
{

    public $department;
    public $is_old_data;

    public function mount($department)
    {
        $this->department = $department;
        $checkOldData = \App\Models\Department::where('id', $department['id'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-department-item');
    }
}
