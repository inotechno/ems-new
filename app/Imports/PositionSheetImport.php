<?php

namespace App\Imports;

use App\Models\Position;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PositionSheetImport implements ToModel, WithHeadingRow
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
        $department_id = $row['department_id'];

        return Position::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'department_id' => $department_id,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
