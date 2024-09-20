<?php

namespace App\Imports;

use App\Jobs\GenerateQRCode;
use App\Models\Site;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiteSheetImport implements ToModel, WithHeadingRow
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
        $uid = $row['uid'];
        $name = $row['name'];
        $longitude = $row['longitude'];
        $latitude = $row['latitude'];

        if($uid === null) {
            $uid = Str::uuid();
        }

        $site = Site::updateOrCreate([
            'id' => $id,
        ], [
            'uid' => $uid,
            'name' => $name,
            'longitude' => $longitude,
            'latitude' => $latitude,
        ]);

        if($site->wasRecentlyCreated) {
            GenerateQRCode::dispatch($site);
        }

        return $site;
    }

    public function headingRow(): int
    {
        return 1;
    }
}
