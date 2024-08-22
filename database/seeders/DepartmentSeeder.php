<?php

namespace Database\Seeders;

use App\Models\Site;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentNames = [
            'Human Resources', 'Finance', 'Marketing', 'Sales', 'Engineering',
            'Product Development', 'Customer Support', 'IT', 'Legal', 'Operations',
            'Research and Development', 'Business Development', 'Training', 'Administration',
            'Design', 'Quality Assurance', 'Supply Chain', 'Project Management', 'Health & Safety',
            'Logistics', 'Purchasing'
        ];

        foreach ($departmentNames as $departmentName) {
            $department = Department::create([
                'name' => $departmentName,
                'supervisor_id' => Employee::inRandomOrder()->first()->id,
                'site_id' => Site::inRandomOrder()->first()->id
            ]);
        }
    }
}
