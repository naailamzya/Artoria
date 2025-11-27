<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $members = User::where('role', 'member')->get();
        $categories = Category::all();
        $tags = Tag::all();

        foreach ($members as $member) {
            $artworkCount = rand(2, 8);
            
            for ($i = 0; $i < $artworkCount; $i++) {
                $artwork = Artwork::create([
                    'user_id' => $member->id,
                    'category_id' => $categories->random()->id,
                    'title' => fake()->sentence(rand(3, 6)),
                    'description' => fake()->paragraph(3),
                    'image_path' => 'artworks/' . fake()->uuid() . '.jpg',
                    'likes_count' => rand(0, 150),
                    'views_count' => rand(10, 1000),
                ]);

                $randomTags = $tags->random(rand(3, 6));
                $artwork->tags()->attach($randomTags->pluck('id')->toArray());

                foreach ($randomTags as $tag) {
                    $tag->incrementUsage();
                }
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $artwork = Artwork::create([
                'user_id' => $members->random()->id,
                'category_id' => $categories->random()->id,
                'title' => fake()->sentence(rand(3, 6)),
                'description' => fake()->paragraph(3),
                'image_path' => 'artworks/' . fake()->uuid() . '.jpg',
                'likes_count' => rand(200, 1000),
                'views_count' => rand(1000, 5000),
            ]);

            $randomTags = $tags->random(rand(3, 6));
            $artwork->tags()->attach($randomTags->pluck('id')->toArray());
            
            foreach ($randomTags as $tag) {
                $tag->incrementUsage();
            }
        }

        $this->command->info('Artworks seeded successfully!');
    }
}