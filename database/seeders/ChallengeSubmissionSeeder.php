<?php

namespace Database\Seeders;

use App\Models\ChallengeSubmission;
use Illuminate\Database\Seeder;

class ChallengeSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $submissions = [
            ['challenge_id' => 1, 'artwork_id' => 1], // Andi's Sunset Dreams
            ['challenge_id' => 1, 'artwork_id' => 2], // Andi's Ocean Waves
            ['challenge_id' => 1, 'artwork_id' => 7], // Maya's Coffee Brand

            ['challenge_id' => 2, 'artwork_id' => 6], // Rudi's Street Photography

            ['challenge_id' => 4, 'artwork_id' => 9], // Fajar's Fantasy Warrior
            ['challenge_id' => 4, 'artwork_id' => 10], // Fajar's Cute Monster
        ];

        foreach ($submissions as $submission) {
            ChallengeSubmission::create($submission);
        }

        $this->command->info('Challenge Submissions seeded successfully!');
    }
}