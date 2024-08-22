<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('id_ID')->name(),
            'site_id' => Site::inRandomOrder()->first()->id,
            'supervisor_id' => Employee::inRandomOrder()->first()->id,
        ];
    }
}
