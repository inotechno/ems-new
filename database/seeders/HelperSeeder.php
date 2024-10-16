<?php

namespace Database\Seeders;

use App\Models\Helper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HelperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Helper::create([
            'code' => 'financial_request_type',
            'name' => 'Reimburse',
            'value' => 'reimburse'
        ]);

        Helper::create([
            'code' => 'financial_request_type',
            'name' => 'Cash Advance',
            'value' => 'cash_advance'
        ]);

        Helper::create([
            'code' => 'financial_request_type',
            'name' => 'Other',
            'value' => 'other'
        ]);

        Helper::create([
            'code' => 'machine_type',
            'name' => 'Fingerprint',
            'value' => 'fingerprint'
        ]);

        Helper::create([
            'code' => 'machine_type',
            'name' => 'Access Control',
            'value' => 'access_control'
        ]);
    }
}
