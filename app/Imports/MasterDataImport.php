<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterDataImport implements WithMultipleSheets
{
    public function sheets(): array
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
