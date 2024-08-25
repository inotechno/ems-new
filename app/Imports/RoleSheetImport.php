<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Role;

class RoleSheetImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row[0];
        $name = $row[1];
        $guard_name = $row[2];

        return Role::updateOrCreate(
            ['id' => $id],
            ['name' => $name, 'guard_name' => $guard_name]
        );
    }
}
