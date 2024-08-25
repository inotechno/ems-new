<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\ToModel;

class DepartmentSheetImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $id = $row['0'];
        $name = $row['1'];
        $site_id = $row['2'];
        $supervisor_id = $row['3'];

        $department = Department::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'site_id' => $site_id,
            'supervisor_id' => $supervisor_id,
        ]);

        return $department;
    }
}
