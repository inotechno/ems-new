<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesPositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Jumlah entri yang ingin ditambahkan
        $entries = 20; // Sesuaikan jumlah entri yang diinginkan

        for ($i = 0; $i < $entries; $i++) {
            DB::table('employees_positions')->insert([
                'employee_id' => Employee::inRandomOrder()->first()->id,
                'position_id' => Position::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
