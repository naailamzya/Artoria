<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'member',
            'status' => 'active',
            'display_name' => fake()->userName(),
            'bio' => fake()->paragraph(2),
            'instagram_link' => 'https://instagram.com/' . fake()->userName(),
            'github_link' => 'https://github.com/' . fake()->userName(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'status' => 'active',
        ]);
    }

    public function curator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'curator',
            'status' => 'active',
        ]);
    }

    public function pendingCurator(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'curator',
            'status' => 'pending',
        ]);
    }

    public function member(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'member',
            'status' => 'active',
        ]);
    }
}