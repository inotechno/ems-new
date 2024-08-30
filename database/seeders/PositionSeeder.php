<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // \App\Models\Position::factory(20)->create();
        DB::table('positions')->insert([
            // SDM
            ['name' => 'Komisaris', 'department_id' => 1],
            ['name' => 'SDM', 'department_id' => 1],

            // Proyek
            ['name' => 'Direktur Proyek', 'department_id' => 2],
            ['name' => 'Akun Eksekutif', 'department_id' => 2],
            ['name' => 'Creative Design Team', 'department_id' => 2],
            ['name' => 'Pemasaran', 'department_id' => 2],

            // Keuangan
            ['name' => 'Direktur Keuangan', 'department_id' => 3],
            ['name' => 'Admin', 'department_id' => 3],
            ['name' => 'Keuangan', 'department_id' => 3],

            // Teknis
            ['name' => 'Direktur Teknis', 'department_id' => 4],
            ['name' => 'Visual Lab Head Div', 'department_id' => 4],
            ['name' => 'Visual Lab Team', 'department_id' => 4],

            // Kreatif
            ['name' => 'Direktur Kreatif', 'department_id' => 5],
            ['name' => 'Creative Planner', 'department_id' => 5],
            ['name' => 'Creative Design Team', 'department_id' => 5],
            ['name' => 'Creative Head', 'department_id' => 5],
            ['name' => 'Lead Teknis', 'department_id' => 5],
            ['name' => 'Lead Motion', 'department_id' => 5],
            ['name' => 'Creative Team', 'department_id' => 5],
        ]);
    }
}
