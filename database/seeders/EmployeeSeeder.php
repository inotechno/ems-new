<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            // 'Administrator',
            // 'Director',
            // 'Finance',
            // 'HR',
            'Employee',
            // 'Project Manager',
        ];

        User::factory(10)->create()->each(function ($user) use ($roles) {
            Employee::factory()->create([
                'user_id' => $user->id, // Mengaitkan employee dengan user yang baru dibuat
            ]);

            $user->assignRole($roles[array_rand($roles)]);
        });
    }
}
