<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Challenge>
 */
class ChallengeFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Neon Dreams Challenge',
            'Dark Fantasy Art Contest',
            'Cyberpunk City Challenge',
            'Character Design Showdown',
            'Abstract Emotions Challenge',
            'Retro Futurism Contest',
            'Nature vs Technology',
            'Monochrome Madness',
            'Creature Design Challenge',
            'Sci-Fi Landscape Contest',
        ];

        $startDate = now()->addDays(rand(-30, 10));
        $endDate = (clone $startDate)->addDays(rand(14, 45));

        return [
            'curator_id' => User::factory()->curator(),
            'title' => fake()->randomElement($titles),
            'description' => fake()->paragraphs(3, true),
            'rules' => "- Original artwork only\n- Submit by deadline\n- Follow the theme\n- One entry per person",
            'prizes' => "🥇 1st Place: $500 + Featured spot\n🥈 2nd Place: $300\n🥉 3rd Place: $100",
            'banner_image' => 'challenges/' . fake()->uuid() . '.jpg',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => fake()->randomElement(['active', 'draft', 'ended']),
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(20),
        ]);
    }

    public function ended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ended',
            'start_date' => now()->subDays(45),
            'end_date' => now()->subDays(5),
        ]);
    }
}