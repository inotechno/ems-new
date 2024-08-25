<?php

namespace App\Imports;

use App\Models\Machine;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MachineSheetImport implements ToModel
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
        $ip_address = $row[2];
        $port = $row[3];
        $comkey = $row[4];
        $is_active = $row[5];
        $password = $row[6];

        return Machine::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'ip_address' => $ip_address,
            'port' => $port,
            'comkey' => $comkey,
            'is_active' => $is_active,
            'password' => $password,
        ]);
    }
}
