<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
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
            'employee_id' => User::first()->employee->id,
            // 'employee_id' => Employee::all()->random()->id,
            'machine_id' => Machine::all()->random()->id,
            'attendance_method_id' => 1,
            'timestamp' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'site_id' => 1,
            'longitude' => $this->faker->longitude(),
            'latitude' => $this->faker->latitude(),
            'notes' => $this->faker->sentence,
            'image_path' => 'https://cdn.prod.website-files.com/5d8a2888296e91abbdcb65f0/6368c88cda30aae9cd4eccc5_On%20Time%20-%2001.png', // Assuming an image path or URL is stored
            'image_url' => 'https://cdn.prod.website-files.com/5d8a2888296e91abbdcb65f0/6368c88cda30aae9cd4eccc5_On%20Time%20-%2001.png',
        ];
    }
}
