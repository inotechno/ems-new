<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@tpm.id',
            'password' => bcrypt('password'),
        ]);

        Employee::factory()->create([
            'user_id' => $administrator->id, // Mengaitkan employee dengan user yang baru dibuat
        ]);

        $administrator->assignRole(['Administrator', 'Employee']);
    }
}
