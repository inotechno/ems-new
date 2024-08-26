<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class RoleSheetImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row['id'];
        $name = $row['name'];
        $guard_name = $row['guard_name'];

        return Role::updateOrCreate(
            ['id' => $id],
            ['name' => $name, 'guard_name' => $guard_name]
        );
    }

    public function headingRow(): int
    {
        return 1;
    }
}
