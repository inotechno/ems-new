<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Spatie\Permission\Models\Role;

class RoleSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Role::all();
    }

    public function map($role): array
    {
        return [
            $role->id,
            $role->name,
            $role->guard_name
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Guard Name',
        ];
    }

    public function title(): string
    {
        return 'Roles';
    }
}
