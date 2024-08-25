<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class DepartmentSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Department::all();
    }

    public function map($department): array
    {
        return [
            $department->id,
            $department->name,
            $department->site_id,
            $department->supervisor_id,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Site ID',
            'Supervisor ID',
        ];
    }

    public function title(): string
    {
        return 'Departments';
    }
}
