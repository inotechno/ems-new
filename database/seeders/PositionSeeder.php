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
             // PRESIDENT DIRECTOR
             ['name' => 'PRESIDENT DIRECTOR', 'department_id' => 1],

             // HRD
             ['name' => 'HUMAN RESOURCES MANAGER', 'department_id' => 2],
             ['name' => 'HUMAN RESOURCES OFFICER', 'department_id' => 2],

             // OPERATIONAL
             ['name' => 'MARKETING', 'department_id' => 5],
             ['name' => 'PIC', 'department_id' => 5],

             // FINANCE
             ['name' => 'FINANCE DIRECTOR', 'department_id' => 4],
             ['name' => 'ADMINISTRATOR', 'department_id' => 4],
             ['name' => 'FINANCE OFFICER', 'department_id' => 4],

             // IT
             ['name' => 'IT MANAGER', 'department_id' => 3],
             ['name' => 'IT PROGRAMMER', 'department_id' => 3],
             ['name' => 'IT SUPPORT', 'department_id' => 3],
             ['name' => 'SOSIAL MEDIA MANAGER', 'department_id' => 3],
             ['name' => 'SOSIAL MEDIA SPECIALIST', 'department_id' => 3],

        ]);
    }
}
