<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengeEntry;
use App\Models\User;
use App\Models\Artwork;
use App\Helpers\ImageHelper;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $bannerCount = ImageHelper::getSampleImageCount('banners');
        
        if ($bannerCount > 0) {
            $this->command->info("Found {$bannerCount} sample banners!");
        } else {
            $this->command->warn("No sample banners found. Will generate placeholders.");
            $this->command->info("Add images to: storage/app/public/samples/banners/");
        }

        $this->command->info('Creating challenges with banners...');

        $curators = User::where('role', 'curator')
                        ->where('status', 'active')
                        ->get();

        $challengeNumber = 0;
        $totalChallenges = $curators->count() * 2;

        foreach ($curators as $curator) {
            $challengeNumber++;
            $this->command->info("Creating challenge {$challengeNumber}/{$totalChallenges} (Active)...");
            
            $bannerPath = ImageHelper::getRandomBanner();
            
            $activeChallenge = Challenge::factory()->active()->create([
                'curator_id' => $curator->id,
                'banner_image' => $bannerPath,
            ]);

            $artworks = Artwork::inRandomOrder()->limit(rand(5, 15))->get();
            foreach ($artworks as $artwork) {
                ChallengeEntry::create([
                    'challenge_id' => $activeChallenge->id,
                    'artwork_id' => $artwork->id,
                    'user_id' => $artwork->user_id,
                ]);
            }

            $challengeNumber++;
            $this->command->info("Creating challenge {$challengeNumber}/{$totalChallenges} (Ended with winners)...");
            
            $bannerPath = ImageHelper::getRandomBanner();
            
            $endedChallenge = Challenge::factory()->ended()->create([
                'curator_id' => $curator->id,
                'banner_image' => $bannerPath,
            ]);

            $endedArtworks = Artwork::inRandomOrder()->limit(rand(10, 20))->get();
            foreach ($endedArtworks as $index => $artwork) {
                ChallengeEntry::create([
                    'challenge_id' => $endedChallenge->id,
                    'artwork_id' => $artwork->id,
                    'user_id' => $artwork->user_id,
                    'is_winner' => $index < 3, 
                ]);
            }
        }

        $this->command->info('Challenges created successfully with banners!');
    }
}