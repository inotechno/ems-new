<?php

namespace App\Livewire\ImportMasterData;

use Livewire\Component;

class PreviewSiteItem extends Component
{
    public $site;
    public $is_old_data;

    public function mount($site)
    {
        $this->site = $site;
        $checkOldData = \App\Models\Site::where('id', $site['id'])->first();
        $this->is_old_data = $checkOldData ? true : false;
    }

    public function render()
    {
        return view('livewire.import-master-data.preview-site-item');
    }
}
