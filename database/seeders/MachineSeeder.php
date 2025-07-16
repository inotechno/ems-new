<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        Machine::create([
            'name' => 'TPM Fingerprint',
            'site_id' => 1,
            'ip_address' => '192.168.20.221',
            'port' => 4370,
            'is_active' => 1,
            'machine_type_id' => 4
        ]);

        Machine::create([
            'name' => 'TPM Door IN',
            'site_id' => 1,
            'ip_address' => '192.168.20.201',
            'port' => 80,
            'is_active' => 1,
            'machine_type_id' => 5
        ]);

        Machine::create([
            'name' => 'TPM Door OUT',
            'site_id' => 1,
            'ip_address' => '192.168.20.202',
            'port' => 80,
            'is_active' => 1,
            'machine_type_id' => 5
        ]);

    }
}
