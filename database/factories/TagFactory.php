<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'digital', 'art', 'illustration', 'design', 'creative',
            'painting', 'sketch', 'anime', 'fantasy', 'portrait',
            'landscape', '3d', 'abstract', 'colorful', 'dark',
            'minimalist', 'concept', 'character', 'nature', 'urban',
            'watercolor', 'oil-painting', 'pencil', 'ink', 'photography',
            'surreal', 'cyberpunk', 'steampunk', 'gothic', 'vintage',
            'modern', 'contemporary', 'pop-art', 'realism', 'impressionism',
            'line-art', 'vector', 'pixel-art', 'low-poly', 'isometric',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'usage_count' => 0,
        ];
    }
}