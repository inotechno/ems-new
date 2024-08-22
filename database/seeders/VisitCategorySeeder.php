<?php

namespace Database\Seeders;

use App\Models\VisitCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VisitCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VisitCategory::create([
            'name' => 'Management Meeting',
        ]);

        VisitCategory::create([
            'name' => 'Patroli',
        ]);

        VisitCategory::create([
            'name' => 'Koordinasi',
        ]);
    }
}
