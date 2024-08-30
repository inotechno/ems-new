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
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@imajiwa.id',
            'password' => bcrypt('password'),
        ]);

        $administrator->assignRole('Administrator');

    }
}
