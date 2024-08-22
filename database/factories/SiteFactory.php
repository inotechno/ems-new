<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Site>
 */
class SiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uid' => fake('id_ID')->uuid(),
            'name' => fake('id_ID')->company(),
            'longitude' => fake('id_ID')->longitude(),
            'latitude' => fake('id_ID')->latitude(),
            'address' => fake('id_ID')->address(),
            'image_url' => fake('id_ID')->imageUrl(640, 480),
            'image_path' => fake('id_ID')->imageUrl(640, 480),
            'qrcode_path' => fake('id_ID')->imageUrl(640, 480),
            'qrcode_url' => fake('id_ID')->imageUrl(640, 480),
        ];
    }
}
