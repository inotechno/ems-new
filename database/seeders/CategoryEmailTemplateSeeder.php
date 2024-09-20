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

        // Absent Request

        CategoryEmailTemplate::create([
            'name' => 'Recipient Absent Request',
            'slug' => 'recipient-absent-request',
            'description' => 'Untuk email penerima request absent',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Sender Absent Request',
            'slug' => 'sender-absent-request',
            'description' => 'untuk pengirim request absent',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Approved Absent Request',
            'slug' => 'approved-absent-request',
            'description' => 'Jika Absent Request Sudah Di Approve maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Rejected Absent Request',
            'slug' => 'rejected-absent-request',
            'description' => 'Jika Absent Request Di Reject maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);


        // Leave Request

        CategoryEmailTemplate::create([
            'name' => 'Recipient Leave Request',
            'slug' => 'recipient-leave-request',
            'description' => 'Untuk email penerima request leave',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Sender Leave Request',
            'slug' => 'sender-leave-request',
            'description' => 'untuk pengirim request leave',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Approved Leave Request',
            'slug' => 'approved-leave-request',
            'description' => 'Jika Leave Request Sudah Di Approve maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Rejected Leave Request',
            'slug' => 'rejected-leave-request',
            'description' => 'Jika Leave Request Di Reject maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);


        // Financial Request

        CategoryEmailTemplate::create([
            'name' => 'Recipient Financial Request',
            'slug' => 'recipient-financial-request',
            'description' => 'Untuk email penerima request financial',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Sender Financial Request',
            'slug' => 'sender-financial-request',
            'description' => 'untuk pengirim request financial',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Approved Financial Request',
            'slug' => 'approved-financial-request',
            'description' => 'Jika Financial Request Sudah Di Approve maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);

        CategoryEmailTemplate::create([
            'name' => 'Rejected Financial Request',
            'slug' => 'rejected-financial-request',
            'description' => 'Jika Financial Request Di Reject maka email ini yang akan di kirimkan kepada user yang mengajukan',
        ]);
    }
}
