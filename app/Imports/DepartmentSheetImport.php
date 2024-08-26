<?php

namespace App\Imports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepartmentSheetImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $id = $row['id'];
        $name = $row['name'];
        $site_id = $row['site_id'];
        $supervisor_id = $row['supervisor_id'];

        $department = Department::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'site_id' => $site_id,
            'supervisor_id' => $supervisor_id,
        ]);

        // dd($department);
        return $department;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
