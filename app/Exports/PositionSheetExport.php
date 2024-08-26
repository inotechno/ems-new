<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PositionSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Position::with('department')->get();
    }

    public function map($position): array
    {
        return [
            $position->id,
            $position->name,
            $position->department->id,
            $position->department->name
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Department ID',
            'Department Name'
        ];
    }

    public function title(): string
    {
        return 'Positions';
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            'D'  => ['font' => ['color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '7C7C7C']]],
        ];
    }
}
