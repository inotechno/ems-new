<?php

namespace App\Exports;

use App\Models\Site;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class SiteSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Site::all();
    }

    public function map($site): array
    {
        return [
            $site->id,
            $site->uid,
            $site->name,
            $site->longitude,
            $site->latitude
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'UID',
            'Name',
            'Longitude',
            'Latitude',
        ];
    }

    public function title(): string
    {
        return 'Sites';
    }
}
