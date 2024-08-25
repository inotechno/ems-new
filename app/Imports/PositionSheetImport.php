<?php

namespace App\Imports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\ToModel;

class PositionSheetImport implements ToModel
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
        $department_id = $row[2];

        return Position::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'department_id' => $department_id,
        ]);
    }
}
