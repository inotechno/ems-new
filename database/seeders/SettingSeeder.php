<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_title',
                'value' => 'Portal Monitoring Trimitra Putra Mandiri'
            ],
            [
                'key' => 'app_name',
                'value' => 'Portal TPM'
            ],
            [
                'key' => 'app_description',
                'value' => 'Portal Monitoring Trimitra Putra Mandiri aplikasi yang digunakan untuk monitoring karyawan PT. Trimitra Putra Mandiri'
            ],
            [
                'key' => 'app_logo_full_dark',
                'value' => 'https://ems.tpm-facility.com/images/logo-full.png'
            ],
            [
                'key' => 'app_logo_full_light',
                'value' => 'https://ems.tpm-facility.com/images/logo-full.png'
            ],
            [
                'key' => 'app_logo_small_dark',
                'value' => 'https://ems.tpm-facility.com/images/logo.png'
            ],
            [
                'key' => 'app_logo_small_light',
                'value' => 'https://ems.tpm-facility.com/images/logo.png'
            ],
            [
                'key' => 'maps_api_key',
                'value' => 'AIzaSyAIAst2Zattt8a673x8hHQ6J5KV6nISGOk'
            ],
            [
                'key' => 'app_version',
                'value' => '2.0.0'
            ],
            [
                'key' => 'app_author',
                'value' => 'Achmad Fatoni'
            ],
            [
                'key' => 'app_author_url',
                'value' => 'https://inotechno.my.id'
            ],
            [
                'key' => 'app_license',
                'value' => 'MIT'
            ],
            [
                'key' => 'app_license_url',
                'value' => 'https://opensource.org/licenses/MIT'
            ],
            [
                'key' => 'app_copyright',
                'value' => 'Copyright (c) 2022 TPM Facility. All rights reserved.'
            ],
            [
                'key' => 'app_currency',
                'value' => 'IDR'
            ],
            [
                'key' => 'app_currency_symbol',
                'value' => 'Rp'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@rumahaplikasi.co.id'
            ],
            [
                'key' => 'contact_phone',
                'value' => '(021) 29305768'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Kompleks Dutamas Fatmawati Blok B2 No. 26, RT.1/RW.5, Cipete Utara, Kec. Kby. Baru, Kota Jakarta Selatan'
            ],
            [
                'key' => 'contact_city',
                'value' => 'Jakarta Selatan'
            ],
            [
                'key' => 'contact_country',
                'value' => 'Indonesia',
            ],
            [
                'key' => 'contact_zip',
                'value' => '12150',
            ],
            [
                'key' => 'contact_map',
                'value' => 'https://maps.app.goo.gl/r6MaaRyWcGhReUa79',
            ],
        ];

        // Masukkan data ke tabel settings
        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']], // Mencari berdasarkan key
                ['value' => $setting['value']] // Mengupdate atau membuat
            );
        }
    }
}
