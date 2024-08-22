<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake('id_ID')->sentence(3),
            'description' => fake('id_ID')->paragraph(10),
            'start_date' => fake('id_ID')->date(),
            'end_date' => fake('id_ID')->date(),
            'status' => fake('id_ID')->randomElement(['not_started', 'in_progress', 'completed', 'on_hold', 'cancelled']),
            'employee_id' => Employee::inRandomOrder()->first()->id,
            'code' => fake('id_ID')->sentence(3),
        ];
    }
}
