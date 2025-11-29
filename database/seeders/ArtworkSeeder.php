<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Helpers\ImageHelper;
use Illuminate\Database\Seeder;

class ArtworkSeeder extends Seeder
{
    public function run(): void
    {
        $artworkCount = ImageHelper::getSampleImageCount('artworks');
        
        if ($artworkCount > 0) {
            $this->command->info("Found {$artworkCount} sample artworks!");
        } else {
            $this->command->warn("No sample artworks found. Will generate placeholders.");
            $this->command->info("Add images to: storage/app/public/samples/artworks/");
        }

        $this->command->info('Creating artworks with images...');

        $members = User::where('role', 'member')->get();
        $categories = Category::all();
        $tags = Tag::all();

        $counter = 0;

        foreach ($members as $member) {
            $artworkCount = rand(2, 8);
            
            for ($i = 0; $i < $artworkCount; $i++) {
                $counter++;
                
                if ($counter % 10 === 0 || $counter === 1) {
                    $this->command->info("  → Artwork {$counter}");
                }

                $imagePath = ImageHelper::getRandomArtwork();

                $artwork = Artwork::create([
                    'user_id' => $member->id,
                    'category_id' => $categories->random()->id,
                    'title' => fake()->sentence(rand(3, 6)),
                    'description' => fake()->paragraph(3),
                    'image_path' => $imagePath,
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

        $this->command->info('Creating 10 featured artworks...');
        for ($i = 0; $i < 10; $i++) {
            $counter++;
            $this->command->info("  → Featured artwork " . ($i + 1) . "/10");
            
            $imagePath = ImageHelper::getRandomArtwork();

            $artwork = Artwork::create([
                'user_id' => $members->random()->id,
                'category_id' => $categories->random()->id,
                'title' => fake()->sentence(rand(3, 6)),
                'description' => fake()->paragraph(3),
                'image_path' => $imagePath,
                'likes_count' => rand(200, 1000),
                'views_count' => rand(1000, 5000),
            ]);

            $randomTags = $tags->random(rand(3, 6));
            $artwork->tags()->attach($randomTags->pluck('id')->toArray());
            
            foreach ($randomTags as $tag) {
                $tag->incrementUsage();
            }
        }

        $this->command->info("Total {$counter} artworks created successfully!");
    }
}