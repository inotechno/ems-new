<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepartmentSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Department::with('site')->get();
    }

    public function map($department): array
    {
        return [
            $department->id,
            $department->name,
            $department->site_id,
            $department->supervisor_id,
            $department->site->name,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Site ID',
            'Supervisor ID',
            'Site Name',
        ];
    }

    public function title(): string
    {
        return 'Departments';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'E'  => ['font' => ['color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '7C7C7C']]],
        ];
    }
}
