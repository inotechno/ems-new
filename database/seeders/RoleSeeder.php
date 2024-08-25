<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Role::create([
            'name' => 'Administrator',
        ]);

        $director = Role::create([
            'name' => 'Director',
        ]);

        $finance = Role::create([
            'name' => 'Finance',
        ]);

        $hr = Role::create([
            'name' => 'HR',
        ]);

        $employee = Role::create([
            'name' => 'Employee',
        ]);

        $project_manager = Role::create([
            'name' => 'Project Manager',
        ]);

        $permissions = [
            // Dashboard
            'view:dashboard' => ['Employee', 'HR', 'Finance', 'Director', 'Administrator', 'Project Manager'],

            // Import Master Data
            'view:import_master_data' => ['HR', 'Administrator'],

            // Export Master Data
            'view:export_master_data' => ['HR', 'Administrator'],

            // User
            'view:user' => ['HR', 'Director', 'Administrator'],
            'create:user' => ['HR', 'Administrator'],
            'update:user' => ['HR', 'Administrator'],
            'delete:user' => ['HR', 'Administrator'],

            // Employee
            'view:employee' => ['HR', 'Director', 'Administrator', 'Project Manager'],
            'create:employee' => ['HR', 'Administrator'],
            'update:employee' => ['HR', 'Administrator'],
            'delete:employee' => ['HR', 'Administrator'],

            // Position
            'view:position' => ['HR', 'Director', 'Administrator', 'Project Manager'],
            'create:position' => ['HR', 'Administrator'],
            'update:position' => ['HR', 'Administrator'],
            'delete:position' => ['HR', 'Administrator'],

            // Department
            'view:department' => ['Employee', 'Finance', 'HR', 'Director', 'Administrator'],
            'create:department' => ['Administrator'],
            'update:department' => ['Administrator'],
            'delete:department' => ['Administrator'],

            // Site
            'view:site' => ['Employee', 'HR', 'Director', 'Administrator'],
            'create:site' => ['HR', 'Administrator'],
            'update:site' => ['HR', 'Administrator'],
            'delete:site' => ['HR', 'Administrator'],

            // Visit
            'view:visit' => ['Employee', 'HR', 'Director', 'Administrator'],
            'create:visit' => ['Employee', 'Administrator'],
            'update:visit' => ['Administrator'],
            'delete:visit' => ['Administrator'],

            // Visit Category
            'view:visit-category' => ['Administrator'],
            'create:visit-category' => ['Administrator'],
            'update:visit-category' => ['Administrator'],
            'delete:visit-category' => ['Administrator'],

            // Machine
            'view:machine' => ['Administrator'],
            'create:machine' => ['Administrator'],
            'update:machine' => ['Administrator'],
            'delete:machine' => ['Administrator'],

            // Attendance
            'view:attendance' => ['Employee', 'HR', 'Finance', 'Director', 'Administrator'],
            'create:attendance' => ['Employee', 'Administrator'],
            'update:attendance' => ['Administrator'],
            'delete:attendance' => ['Administrator'],

            // Attendance Temp
            'view:attendance-temp' => ['Employee', 'HR', 'Administrator'],
            'create:attendance-temp' => ['Employee', 'Administrator'],
            'update:attendance-temp' => ['Administrator'],
            'delete:attendance-temp' => ['Administrator'],
            'approve:attendance-temp' => ['Administrator', 'HR'],

            // Role
            'view:role' => ['Administrator'],
            'create:role' => ['Administrator'],
            'update:role' => ['Administrator'],
            'delete:role' => ['Administrator'],

            // Permission
            'view:permission' => ['Administrator'],
            'create:permission' => ['Administrator'],
            'update:permission' => ['Administrator'],
            'delete:permission' => ['Administrator'],

            // Settings
            'view:setting' => ['Administrator'],
            'create:setting' => ['Administrator'],
            'update:setting' => ['Administrator'],
            'delete:setting' => ['Administrator'],

            // Daily Report
            'view:daily-report' => ['Employee'],
            'view:daily-report-all' => ['HR', 'Director', 'Administrator'],
            'create:daily-report' => ['Employee', 'Administrator'],
            'update:daily-report' => ['Employee', 'Administrator'],
            'delete:daily-report' => ['Employee', 'Administrator'],

            // Announcement
            'view:announcement' => ['HR', 'Employee', 'Finance', 'Director', 'Administrator'],
            'create:announcement' => ['HR', 'Administrator'],
            'update:announcement' => ['HR', 'Administrator'],
            'delete:announcement' => ['HR', 'Administrator'],

            // Financial Request
            'view:financial-request' => ['Employee'],
            'view:financial-request-all' => ['HR', 'Director', 'Finance', 'Administrator'],
            'create:financial-request' => ['Finance', 'Administrator'],
            'update:financial-request' => ['Finance', 'Administrator'],
            'delete:financial-request' => ['Finance', 'Administrator'],
            'approve:financial-request' => ['Employee', 'Finance', 'Director', 'Administrator'],

            // Absence Request
            'view:absence-request' => ['Employee'],
            'view:absence-request-all' => ['HR', 'Director', 'Administrator'],
            'create:absence-request' => ['Employee', 'HR', 'Administrator'],
            'update:absence-request' => ['Employee', 'HR', 'Administrator'],
            'delete:absence-request' => ['Employee', 'HR', 'Administrator'],
            'approve:absence-request' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Leave Request
            'view:leave-request' => ['Employee'],
            'view:leave-request-all' => ['HR', 'Director', 'Administrator'],
            'create:leave-request' => ['Employee', 'HR', 'Administrator'],
            'update:leave-request' => ['Employee', 'HR', 'Administrator'],
            'delete:leave-request' => ['Employee', 'HR', 'Administrator'],
            'approve:leave-request' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Report
            'view:report-attendance' => ['Employee', 'Finance', 'HR', 'Director', 'Administrator'],
            'view:report-daily-report' => ['Employee', 'Finance', 'HR', 'Director', 'Administrator'],
            'view:report-financial-request' => ['Employee', 'Finance', 'Director', 'Administrator'],
            'view:report-absence-request' => ['Employee', 'HR', 'Director', 'Administrator'],
            'view:report-leave-request' => ['Employee', 'HR', 'Director', 'Administrator'],
            'view:report-visit' => ['Employee', 'HR', 'Director', 'Administrator'],

            // Project
            'view:project' => ['Employee', 'HR', 'Director', 'Administrator', 'Project Manager'],
            'create:project' => ['Administrator', 'Project Manager'],
            'update:project' => ['Administrator', 'Project Manager'],
            'delete:project' => ['Administrator', 'Project Manager'],
        ];

        foreach ($permissions as $permissionName => $roles) {
            $permission = Permission::create([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);

            // Assign permission to roles
            foreach ($roles as $roleName) {
                $role = Role::firstOrCreate(['name' => $roleName]);
                $role->givePermissionTo($permission);
            }
        }
    }
}
