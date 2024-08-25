<?php

namespace App\Exports;

use App\Models\Machine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MachineSheetExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Machine::all();
    }

    public function map($machine): array
    {
        return [
            $machine->id,
            $machine->name,
            $machine->ip_address,
            $machine->port,
            $machine->comkey,
            $machine->is_active,
            $machine->password,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'IP Address',
            'Port',
            'Comkey',
            'Is Active',
            'Password',
        ];
    }

    public function title(): string
    {
        return 'Machines';
    }
}
