<?php

namespace Database\Seeders;

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
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'administrator@ems.com',
            'password' => bcrypt('password'),
        ]);

        $administrator->assignRole('Administrator');
    }
}
