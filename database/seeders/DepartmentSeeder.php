<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $departmentNames = [
        //     'Human Resources', 'Finance',
        //    'Administration','Project Management'
        // ];

        // foreach ($departmentNames as $departmentName) {
        //     $department = Department::create([
        //         'name' => $departmentName,
        //         'supervisor_id' => Employee::inRandomOrder()->first()->id,
        //         'site_id' => Site::inRandomOrder()->first()->id
        //     ]);
        // }

        DB::table('departments')->insert([
            ['name' => 'HRD', 'site_id' => 1],
            ['name' => 'PROJECT', 'site_id' => 1],
            ['name' => 'FINANCE', 'site_id' => 1],
            ['name' => 'TECHNICAL', 'site_id' => 1],
            ['name' => 'CREATIVE', 'site_id' => 1],
        ]);
    }
}
