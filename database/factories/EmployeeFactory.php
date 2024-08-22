<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->numberBetween(10000000000, 90000000000),
            'leave_remaining' => $this->faker->numberBetween(0, 12),
            'join_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'user_id' => null,
        ];
    }
}
