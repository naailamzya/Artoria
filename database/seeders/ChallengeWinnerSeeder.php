<?php

namespace Database\Seeders;

use App\Models\ChallengeWinner;
use Illuminate\Database\Seeder;

class ChallengeWinnerSeeder extends Seeder
{
    public function run(): void
    {
        $winners = [
            [
                'challenge_id' => 4,
                'submission_id' => 5, 
                'rank' => 1, 
            ],
            [
                'challenge_id' => 4,
                'submission_id' => 6, 
                'rank' => 2, 
            ],
        ];

        foreach ($winners as $winner) {
            ChallengeWinner::create($winner);
        }

        $this->command->info('Challenge Winners seeded successfully!');
    }
}