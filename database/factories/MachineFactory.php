<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'ip_address' => $this->faker->ipv4(),
            'port' => $this->faker->numberBetween(1, 65535),
            'comkey' => $this->faker->numberBetween(1, 255),
            'password' => $this->faker->password(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
