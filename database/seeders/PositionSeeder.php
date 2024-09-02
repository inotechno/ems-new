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
             // THE MAIN COMMISSIONER
             ['name' => 'CHIEF COMMISSIONER', 'department_id' => 1],

             // COMMISSIONER
             ['name' => 'COMMISSIONER', 'department_id' => 2],
 
             // PRESIDENT DIRECTOR
             ['name' => 'PRESIDENT DIRECTOR', 'department_id' => 3],
 
             // HRD
             ['name' => 'HUMAN RESOURCES MANAGER', 'department_id' => 4],
 
             // PROJECT
             ['name' => 'PROJECT DIRECTOR', 'department_id' => 5],
             ['name' => 'ACCOUNT EXECUTIVE', 'department_id' => 5],
             ['name' => 'CREATIVE DESIGN TEAM', 'department_id' => 5],
             ['name' => 'MARKETING', 'department_id' => 5],
 
             // FINANCE
             ['name' => 'FINANCE DIRECTOR', 'department_id' => 6],
             ['name' => 'ADMINISTRATOR', 'department_id' => 6],
             ['name' => 'FINANCE OFFICER', 'department_id' => 6],
 
             // TECHNICAL
             ['name' => 'TECHNICAL DIRECTOR', 'department_id' => 7],
             ['name' => 'VISUAL LAB HEAD', 'department_id' => 7],
             ['name' => 'VISUAL LAB TEAM', 'department_id' => 7],
 
             // CREATIVE
             ['name' => 'CREATIVE DIRECTOR', 'department_id' => 8],
             ['name' => 'CREATIVE PLANNER', 'department_id' => 8],
             ['name' => 'CREATIVE DESIGN TEAM', 'department_id' => 8],
             ['name' => 'CREATIVE HEAD', 'department_id' => 8],
             ['name' => 'TECHNICAL LEAD', 'department_id' => 8],
             ['name' => 'MOTION LEAD', 'department_id' => 8],
             ['name' => 'CREATIVE TEAM', 'department_id' => 8],
        ]);
    }
}
