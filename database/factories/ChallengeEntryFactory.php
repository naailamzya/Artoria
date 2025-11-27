<?php

namespace Database\Factories;

use App\Models\Challenge;
use App\Models\Artwork;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChallengeEntry>
 */
class ChallengeEntryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'challenge_id' => Challenge::factory(),
            'artwork_id' => Artwork::factory(),
            'user_id' => User::factory(),
            'is_winner' => false,
        ];
    }

    public function winner(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_winner' => true,
        ]);
    }
}