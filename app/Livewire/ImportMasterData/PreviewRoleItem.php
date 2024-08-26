<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class PreviewRoleItem extends Component
{
    public $role;
    public $is_old_data;

    public function mount($role)
    {
        $this->role = $role;
        $checkOldData = Role::where('name', $role['name'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-role-item');
    }
}
