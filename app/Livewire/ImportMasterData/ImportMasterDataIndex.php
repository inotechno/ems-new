<?php

namespace App\Livewire\ImportMasterData;

use App\Exports\MasterDataExport;
use App\Imports\MasterDataImport;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportMasterDataIndex extends Component
{
    use LivewireAlert, WithFileUploads;
    public $file;

    protected $rules = [
        'file' => 'required|mimes:xls,xlsx'
    ];

    public function import()
    {
        $this->validate();
        try {
            Excel::import(new MasterDataImport, $this->file->getRealPath());
            $this->alert('success', 'Master Data Imported Successfully');
        } catch (\Exception $e) {
            $this->alert('error', "Message : {$e->getMessage()} Code : {$e->getCode()} Line : {$e->getLine()}");
        }
    }

    public function download()
    {
        return Excel::download(new MasterDataExport, 'template-master-data.xlsx');
    }

    public function render()
    {
        return view('livewire.import-master-data.import-master-data-index')->layout('layouts.app', ['title' => 'Import Master Data']);
    }
}
