<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Digital Art',
                'description' => 'Digital paintings, illustrations, and graphic design',
            ],
            [
                'name' => 'Illustration',
                'description' => 'Hand-drawn and digital illustrations',
            ],
            [
                'name' => 'Photography',
                'description' => 'Professional and artistic photography',
            ],
            [
                'name' => '3D Modeling',
                'description' => '3D renders, sculptures, and models',
            ],
            [
                'name' => 'Character Design',
                'description' => 'Original character concepts and designs',
            ],
            [
                'name' => 'Concept Art',
                'description' => 'Game, film, and environment concept art',
            ],
            [
                'name' => 'Pixel Art',
                'description' => 'Retro and modern pixel artwork',
            ],
            [
                'name' => 'Abstract',
                'description' => 'Abstract and experimental art',
            ],
            [
                'name' => 'Anime/Manga',
                'description' => 'Japanese-inspired art and comics',
            ],
            [
                'name' => 'Fantasy',
                'description' => 'Fantasy worlds, creatures, and magic',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('Categories seeded successfully!');
    }
}