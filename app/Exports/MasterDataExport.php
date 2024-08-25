<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterDataExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Machines' => new MachineSheetExport(),
            'Sites' => new SiteSheetExport(),
            'Departments' => new DepartmentSheetExport(),
            'Positions' => new PositionSheetExport(),
            'Roles' => new RoleSheetExport(),
            'Employees' => new EmployeeSheetExport(),
        ];
    }
}
