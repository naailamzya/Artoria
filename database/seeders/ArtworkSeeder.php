<?php

namespace Database\Seeders;

use App\Models\Artwork;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $artworks = [
            // Andi Pratama's artworks (user_id: 4)
            [
                'user_id' => 4,
                'category_id' => 4, 
                'title' => 'Sunset Dreams',
                'description' => 'A beautiful illustration of sunset over the mountains',
                'file_path' => 'artworks/sunset-dreams.jpg',
            ],
            [
                'user_id' => 4,
                'category_id' => 6, 
                'title' => 'Ocean Waves',
                'description' => 'Digital painting of ocean waves crashing on rocks',
                'file_path' => 'artworks/ocean-waves.jpg',
            ],

            // Dewi Lestari's artworks (user_id: 5)
            [
                'user_id' => 5,
                'category_id' => 3, 
                'title' => 'Futuristic City',
                'description' => '3D model of a futuristic cyberpunk city',
                'file_path' => 'artworks/futuristic-city.jpg',
            ],
            [
                'user_id' => 5,
                'category_id' => 3, 
                'title' => 'Robot Character',
                'description' => '3D character design of a friendly robot',
                'file_path' => 'artworks/robot-character.jpg',
            ],

            // Rudi Hartono's artworks (user_id: 6)
            [
                'user_id' => 6,
                'category_id' => 2, 
                'title' => 'Mobile Banking App',
                'description' => 'Modern UI design for mobile banking application',
                'file_path' => 'artworks/mobile-banking.jpg',
            ],
            [
                'user_id' => 6,
                'category_id' => 1, 
                'title' => 'Street Photography',
                'description' => 'Candid street photography in Jakarta',
                'file_path' => 'artworks/street-photo.jpg',
            ],

            // Maya Sari's artworks (user_id: 7)
            [
                'user_id' => 7,
                'category_id' => 5, 
                'title' => 'Brand Identity - Coffee Shop',
                'description' => 'Complete brand identity design for a coffee shop',
                'file_path' => 'artworks/coffee-brand.jpg',
            ],
            [
                'user_id' => 7,
                'category_id' => 5, 
                'title' => 'Poster Design',
                'description' => 'Music festival poster design',
                'file_path' => 'artworks/poster-design.jpg',
            ],

            // Fajar Ramadhan's artworks (user_id: 8)
            [
                'user_id' => 8,
                'category_id' => 7, 
                'title' => 'Fantasy Warrior',
                'description' => 'Character concept art for fantasy game',
                'file_path' => 'artworks/fantasy-warrior.jpg',
            ],
            [
                'user_id' => 8,
                'category_id' => 7, 
                'title' => 'Cute Monster',
                'description' => 'Cute monster character for children book',
                'file_path' => 'artworks/cute-monster.jpg',
            ],
        ];

        foreach ($artworks as $artwork) {
            Artwork::create($artwork);
        }

        $this->command->info('Artworks seeded successfully!');
    }
}