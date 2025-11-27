<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Artwork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        $comments = [
            'Amazing work! Love the colors! 🎨',
            'This is incredible! How long did it take?',
            'Beautiful composition and lighting!',
            'Wow, the details are stunning! 😍',
            'This deserves more recognition!',
            'Your style is so unique! Keep it up!',
            'Absolutely gorgeous! What software did you use?',
            'The atmosphere in this piece is perfect!',
            'I love how you captured the emotion here',
            'This is fire! 🔥🔥🔥',
            'Incredible talent! Following for more',
            'The color palette is just *chef\'s kiss*',
        ];

        return [
            'user_id' => User::factory(),
            'artwork_id' => Artwork::factory(),
            'content' => fake()->randomElement($comments),
        ];
    }
}