<?php

namespace Database\Seeders;

use App\Models\CategoryInventory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definisikan kategori umum untuk inventaris
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Furniture', 'description' => 'Office furniture items'],
            ['name' => 'Office Supplies', 'description' => 'General office supplies such as stationery'],
            ['name' => 'Software Licenses', 'description' => 'Licenses for various software'],
            ['name' => 'IT Equipment', 'description' => 'IT-related hardware like servers, routers, etc.'],
            ['name' => 'Safety Equipment', 'description' => 'Safety and security equipment'],
            ['name' => 'Maintenance Tools', 'description' => 'Tools used for building or office maintenance'],
        ];

        // Masukkan data kategori ke tabel inventory_categories
        foreach ($categories as $category) {
            CategoryInventory::create($category);
        }
    }
}
