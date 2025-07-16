<?php

namespace App\Imports;

use App\Models\Machine;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MachineSheetImport implements ToModel, WithHeadingRow
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
        $ip_address = $row['ip_address'];
        $port = $row['port'];
        $comkey = $row['comkey'];
        $is_active = $row['is_active'];
        $password = $row['password'];

        return Machine::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'site_id' => $site_id,
            'ip_address' => $ip_address,
            'port' => $port,
            'comkey' => $comkey,
            'is_active' => $is_active,
            'password' => $password,
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }
}
