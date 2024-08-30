<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Machine::create([
            'name' => 'TPM Door IN',
            'ip_address' => '192.168.20.201',
            'port' => 80,
            'is_active' => 1,
        ]);

        Machine::create([
            'name' => 'TPM Door OUT',
            'ip_address' => '192.168.20.202',
            'port' => 80,
            'is_active' => 1,
        ]);

    }
}
