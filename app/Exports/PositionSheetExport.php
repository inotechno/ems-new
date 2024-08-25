<?php

namespace App\Exports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PositionSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle
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
            $position->department->id
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Department ID'
        ];
    }

    public function title(): string
    {
        return 'Positions';
    }
}
