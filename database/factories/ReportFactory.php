<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Artwork;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    public function definition(): array
    {
        $reasons = [
            'Inappropriate content',
            'Copyright infringement',
            'Spam or misleading',
            'Offensive or hateful',
            'Violence or harmful content',
            'Not following community guidelines',
        ];

        return [
            'reporter_id' => User::factory(),
            'reportable_type' => fake()->randomElement([Artwork::class, Comment::class]),
            'reportable_id' => 1,
            'reason' => fake()->randomElement($reasons),
            'status' => 'pending',
        ];
    }

    public function reviewed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'reviewed',
            'admin_action' => 'Content removed',
            'reviewed_by' => User::factory()->admin(),
        ]);
    }
}