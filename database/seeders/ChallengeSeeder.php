<?php

namespace Database\Seeders;

use App\Models\Challenge;
use App\Models\ChallengeEntry;
use App\Models\User;
use App\Models\Artwork;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $curators = User::where('role', 'curator')
                        ->where('status', 'active')
                        ->get();

        foreach ($curators as $curator) {
            $activeChallenge = Challenge::factory()->active()->create([
                'curator_id' => $curator->id,
            ]);

            $artworks = Artwork::inRandomOrder()->limit(rand(5, 15))->get();
            foreach ($artworks as $artwork) {
                ChallengeEntry::create([
                    'challenge_id' => $activeChallenge->id,
                    'artwork_id' => $artwork->id,
                    'user_id' => $artwork->user_id,
                ]);
            }

            $endedChallenge = Challenge::factory()->ended()->create([
                'curator_id' => $curator->id,
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

        $this->command->info('✅ Challenges seeded successfully!');
    }
}