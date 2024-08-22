<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Project;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsEmployees extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insert = 20;

        for ($i = 0; $i < $insert; $i++) {
            DB::table('projects_employees')->insert([
                'project_id' => Project::inRandomOrder()->first()->id,
                'employee_id' => Employee::inRandomOrder()->first()->id,
                'created_at' => now(),
            ]);
        }
    }
}
