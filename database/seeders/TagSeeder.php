<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'digital', 'art', 'illustration', 'design', 'creative',
            'painting', 'sketch', 'anime', 'fantasy', 'portrait',
            'landscape', '3d', 'abstract', 'colorful', 'dark',
            'minimalist', 'concept', 'character', 'nature', 'urban',
            'watercolor', 'oil-painting', 'pencil', 'ink', 'photography',
            'surreal', 'cyberpunk', 'steampunk', 'gothic', 'vintage',
            'modern', 'contemporary', 'pop-art', 'realism', 'impressionism',
            'line-art', 'vector', 'pixel-art', 'low-poly', 'isometric',
            'neon', 'glow', 'retro', 'futuristic', 'sci-fi',
        ];

        foreach ($tags as $tagName) {
            Tag::create(['name' => $tagName]);
        }

        $this->command->info('Tags seeded successfully!');
    }
}