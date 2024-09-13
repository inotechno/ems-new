<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $password =Str::random(10);

        return [
            'name' => fake('id_ID')->name(), // Menggunakan locale Indonesia
            'username' => fake('id_ID')->userName(),
            'email' => fake('id_ID')->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'password_string' => $password,
            'remember_token' => Str::random(10),
            'avatar_url' => 'https://w7.pngwing.com/pngs/205/731/png-transparent-default-avatar-thumbnail.png',
            'avatar_path' => 'https://w7.pngwing.com/pngs/205/731/png-transparent-default-avatar-thumbnail.png',
            'avatar_thumbnail_url' => 'https://w7.pngwing.com/pngs/205/731/png-transparent-default-avatar-thumbnail.png',
            'avatar_thumbnail_path' => 'https://w7.pngwing.com/pngs/205/731/png-transparent-default-avatar-thumbnail.png',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
