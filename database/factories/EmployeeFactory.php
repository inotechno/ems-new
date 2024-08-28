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
            'id' =>  fake('id_ID')->numberBetween(1000000000, 9000000000),
            'user_id' => null,
            'citizen_id' => fake('id_ID')->nik(),
            'leave_remaining' =>  fake('id_ID')->numberBetween(0, 12),
            'join_date' =>  fake('id_ID')->dateTimeBetween('-2 years', 'now'),
            'birth_date' =>  fake('id_ID')->dateTimeBetween('-50 years', '-18 years'),
            'place_of_birth' =>  fake('id_ID')->city,
            'gender' =>  fake('id_ID')->randomElement(['male', 'female']),
            'marital_status' =>  fake('id_ID')->randomElement(['single', 'married']),
            'religion' =>  fake('id_ID')->randomElement(['islam', 'kristen', 'katholik', 'hindu', 'budha', 'konghucu']),
        ];
    }
}
