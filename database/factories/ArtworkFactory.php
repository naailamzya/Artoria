<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artwork>
 */
class ArtworkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'title' => fake()->sentence(rand(3, 6)),
            'description' => fake()->paragraph(3),
            'image_path' => 'artworks/' . fake()->uuid() . '.jpg',
            'likes_count' => rand(0, 150),
            'views_count' => rand(10, 1000),
        ];
    }

    public function popular(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => rand(100, 500),
            'views_count' => rand(500, 2000),
        ]);
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'likes_count' => rand(200, 1000),
            'views_count' => rand(1000, 5000),
        ]);
    }
}