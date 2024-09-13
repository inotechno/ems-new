<?php

namespace Database\Seeders;

use App\Models\CategoryEmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryEmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CategoryEmailTemplate::create([
            'name' => 'New Account',
            'slug' => 'new-account',
            'description' => 'New account created',
        ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Password Reset',
        //     'slug' => 'password-reset',
        //     'description' => 'Password reset',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Password Changed',
        //     'slug' => 'password-changed',
        //     'description' => 'Password changed',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Email Changed',
        //     'slug' => 'email-changed',
        //     'description' => 'Email changed',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Email Verified',
        //     'slug' => 'email-verified',
        //     'description' => 'Email verified',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Email Unverified',
        //     'slug' => 'email-unverified',
        //     'description' => 'Email unverified',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Account Deleted',
        //     'slug' => 'account-deleted',
        //     'description' => 'Account deleted',
        // ]);

        // CategoryEmailTemplate::create([
        //     'name' => 'Account Suspended',
        //     'slug' => 'account-suspended',
        //     'description' => 'Account suspended',
        // ]);

    }
}
