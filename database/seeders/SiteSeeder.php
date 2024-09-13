<?php

namespace Database\Seeders;

use App\Models\Site;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uid = Str::uuid();
        Site::create([
            'uid' => '6c1cb9c4-42d0-4f96-9730-fbbd02fbc047',
            'name' => 'TPM GROUP',
            'longitude' => '106.79883968085',
            'latitude' => '-6.2631216208642',
            'address' => 'Kompleks Dutamas Fatmawati Blok B2 No. 26, RT.1/RW.5, Cipete Utara, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12150, Indonesia',
            'qrcode_url' => 'https://storage.googleapis.com/ems.tpm-facility.com/qrcodes/6c1cb9c4-42d0-4f96-9730-fbbd02fbc047.png',
            'qrcode_path' => 'qrcodes/6c1cb9c4-42d0-4f96-9730-fbbd02fbc047.png',
        ]);

        // Site::factory(10)->create();
    }
}
