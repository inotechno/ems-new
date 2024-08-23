<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => $this->faker->numberBetween(1, 100000),
            'employee_id' => Employee::all()->random()->id,
            'machine_id' => Machine::all()->random()->id,
            'attendance_method_id' => 1,
            'timestamp' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'site_id' => 1,
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'notes' => $this->faker->sentence,
            'image_path' => $this->faker->imageUrl(), // Assuming an image path or URL is stored
            'image_url' => $this->faker->url,
        ];
    }
}
