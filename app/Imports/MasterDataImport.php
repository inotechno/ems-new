<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterDataImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        return [
            'Machines' => new MachineSheetImport(),
            'Sites' => new SiteSheetImport(),
            'Departments' => new DepartmentSheetImport(),
            'Positions' => new PositionSheetImport(),
            'Roles' => new RoleSheetImport(),
            'Employees' => new EmployeeSheetImport(),
        ];
    }
}
