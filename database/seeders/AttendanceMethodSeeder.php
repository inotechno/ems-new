<?php

namespace Database\Seeders;

use App\Models\AttendanceMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AttendanceMethod::create([
            'name' => 'Machine',
        ]);

        AttendanceMethod::create([
            'name' => 'Tag',
        ]);

        AttendanceMethod::create([
            'name' => 'QR Code',
        ]);
    }
}
