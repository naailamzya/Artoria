<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->randomElement([
            'Digital Art',
            'Illustration',
            'Photography',
            '3D Modeling',
            'Character Design',
            'Concept Art',
            'Pixel Art',
            'Abstract',
            'Anime/Manga',
            'Landscape',
            'Portrait',
            'Fantasy',
            'Sci-Fi',
            'Urban Art',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(10),
        ];
    }
}