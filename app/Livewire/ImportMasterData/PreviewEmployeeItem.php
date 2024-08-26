<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewEmployeeItem extends Component
{
    public $employee;
    public $is_old_data;

    public function mount($employee)
    {
        $this->employee = $employee;
        $checkOldData = \App\Models\Employee::where('citizen_id', $employee['citizen_id'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-employee-item');
    }
}
