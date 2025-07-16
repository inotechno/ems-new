<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            VisitCategorySeeder::class,
            SiteSeeder::class,
            MachineSeeder::class,
            DepartmentSeeder::class,
            PositionSeeder::class,
            AttendanceMethodSeeder::class,
            ProjectSeeder::class,
            ProjectsEmployees::class,
            AttendanceSeeder::class,
            HelperSeeder::class,
            CategoryEmailTemplateSeeder::class,
            EmailTemplateSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
