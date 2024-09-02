<?php

namespace Database\Seeders;

use App\Models\StatusInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        StatusInventory::insert([
            [
                'id' => 1,
                'name' => 'Available',
                'color' => '#28a745',
                'slug' => 'available'
            ],
            [
                'id' => 2,
                'name' => 'Assigned',
                'color' => '#ffc107',
                'slug' => 'assigned'
            ],
            [
                'id' => 3,
                'name' => 'Returned',
                'color' => '#dc3545',
                'slug' => 'returned'
            ],
            [
                'id' => 4,
                'name' => 'Lost',
                'color' => '#6c757d',
                'slug' => 'lost'
            ],
            [
                'id' => 5,
                'name' => 'Damaged',
                'color' => '#dc3545',
                'slug' => 'damaged'
            ],
            [
                'id' => 6,
                'name' => 'In Use',
                'color' => '#6c757d',
                'slug' => 'in-use'
            ],
            [
                'id' => 7,
                'name' => 'Under Maintenance',
                'color' => '#28a745',
                'slug' => 'under-maintenance'
            ],
            [
                'id' => 8,
                'name' => 'Retired',
                'color' => '#dc3545',
                'slug' => 'retired'
            ],
        ]);
    }
}
