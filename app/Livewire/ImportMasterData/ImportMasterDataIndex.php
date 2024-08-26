<?php

namespace App\Livewire\ImportMasterData;

use App\Exports\DepartmentSheetExport;
use App\Exports\EmployeeSheetExport;
use App\Exports\MachineSheetExport;
use App\Exports\MasterDataExport;
use App\Exports\PositionSheetExport;
use App\Exports\RoleSheetExport;
use App\Exports\SiteSheetExport;
use App\Imports\DepartmentSheetImport;
use App\Imports\EmployeeSheetImport;
use App\Imports\MasterDataImport;
use App\Imports\PositionSheetImport;
use App\Imports\RoleSheetImport;
use App\Imports\SiteSheetImport;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ImportMasterDataIndex extends Component
{
    use LivewireAlert, WithFileUploads;
    public $file;
    public $type_data;
    public $previewData = [];

    protected $rules = [
        'file' => 'required|mimes:xls,xlsx'
    ];

    public function import()
    {
        $this->validate();
        try {
            if ($this->type_data == 'Employee') {
                $importFile = new EmployeeSheetImport();
            } else if ($this->type_data == 'Department') {
                $importFile = new DepartmentSheetImport();
            } else if ($this->type_data == 'Position') {
                $importFile = new PositionSheetImport();
            } else if ($this->type_data == 'Site') {
                $importFile = new SiteSheetImport();
            } else if ($this->type_data == 'Machine') {
                $importFile = new MachineSheetExport();
            } else if ($this->type_data == 'Role') {
                $importFile = new RoleSheetImport();
            }

            Excel::import($importFile, $this->file->getRealPath());

            // Excel::import($importFile, $this->file->getRealPath());
            $this->alert('success', 'Master Data Imported Successfully');

            return redirect()->route('import.index');
        } catch (\Exception $e) {
            $this->alert('error', "Message : {$e->getMessage()} Code : {$e->getCode()} Line : {$e->getLine()}");
        }
    }

    public function preview()
    {
        if ($this->file) {
            $this->previewData = $this->loadPreview();
        }
        // dd($this->previewData);
    }

    private function loadPreview()
    {
        $this->validate();

        $filePath = $this->file->getRealPath();

        // Use the import class to load the data
        if ($this->type_data == 'Employee') {
            $import = new EmployeeSheetImport();
        } else if ($this->type_data == 'Department') {
            $import = new DepartmentSheetImport();
        } else if ($this->type_data == 'Position') {
            $import = new PositionSheetImport();
        } else if ($this->type_data == 'Site') {
            $import = new SiteSheetImport();
        } else if ($this->type_data == 'Machine') {
            $import = new MachineSheetExport();
        } else if ($this->type_data == 'Role') {
            $import = new RoleSheetImport();
        }

        $collection = $import->toArray($filePath);

        // Retrieve the sheet data (assuming you have only one sheet for preview)
        $sheetData = $collection[0];
        // dd($sheetData);
        if ($this->type_data == 'Employee') {
            // Convert dates for preview data
            $sheetData = array_map(function ($row) {
                if (isset($row['join_date'])) {
                    $row['join_date'] = $this->excelDateToCarbon($row['join_date']);
                }
                if (isset($row['birth_date'])) {
                    $row['birth_date'] = $this->excelDateToCarbon($row['birth_date']);
                }
                return $row;
            }, $sheetData);
        }
        // return $sheetData;
        // Filter out rows where 'ID' is not empty
        $filteredData = array_filter($sheetData, function ($row) {
            return !empty($row['id']); // Adjust 'ID' to match the actual key used in the rows
        });

        return array_values($filteredData); // Re-index array for consistent output
    }

    private function excelDateToCarbon($serialDate)
    {
        // Cek apakah nilai kosong atau null
        if (empty($serialDate)) {
            return null;
        }

        // Cek apakah sudah dalam format tanggal yang valid
        if (Carbon::hasFormat($serialDate, 'Y-m-d')) {
            return $serialDate; // Jika sudah dalam format Y-m-d, langsung kembalikan
        }

        // Cek apakah nilai adalah numerik
        if (is_numeric($serialDate) && $serialDate > 0) {
            $unixDate = ($serialDate - 25569) * 86400;
            return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
        }

        // Jika tidak, kembalikan null atau bisa juga melempar exception
        return null;
    }

    public function download()
    {
        if ($this->type_data == 'Employee') {
            return Excel::download(new EmployeeSheetExport, 'template-employee.xlsx');
        } else if ($this->type_data == 'Department') {
            return Excel::download(new DepartmentSheetExport, 'template-department.xlsx');
        } else if ($this->type_data == 'Position') {
            return Excel::download(new PositionSheetExport, 'template-position.xlsx');
        } else if ($this->type_data == 'Site') {
            return Excel::download(new SiteSheetExport, 'template-site.xlsx');
        } else if ($this->type_data == 'Machine') {
            return Excel::download(new MachineSheetExport, 'template-machine.xlsx');
        } else if ($this->type_data == 'Role') {
            return Excel::download(new RoleSheetExport, 'template-role.xlsx');
        } else {
            $this->alert('error', 'Please Select Type Data');
        }
    }

    public function render()
    {
        return view('livewire.import-master-data.import-master-data-index')->layout('layouts.app', ['title' => 'Import Master Data']);
    }
}
