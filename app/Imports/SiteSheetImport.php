<?php

namespace App\Imports;

use App\Jobs\GenerateQRCode;
use App\Models\Site;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;

class SiteSheetImport implements ToModel
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
        $longitude = $row[2];
        $latitude = $row[3];

        $uid = Str::uuid();
        GenerateQRCode::dispatch($uid);

        return Site::updateOrCreate([
            'id' => $id,
        ], [
            'name' => $name,
            'longitude' => $longitude,
            'latitude' => $latitude,
        ]);
    }
}
