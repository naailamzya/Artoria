<?php

namespace Database\Seeders;

use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $challenges = [
            // Active Challenge by Budi (curator_id: 2)
            [
                'curator_id' => 2,
                'title' => 'Digital Art Challenge 2024',
                'description' => 'Create your best digital artwork with theme: Nature and Technology',
                'rules' => '1. Must be original work
                            2. Size: minimum 1920x1080px
                            3. Format: JPG or PNG
                            4. Submit before deadline',
                'reward' => 5000000,
                'deadline' => Carbon::now()->addDays(30),
                'status' => 'active',
            ],

            // Active Challenge by Siti (curator_id: 3)
            [
                'curator_id' => 3,
                'title' => 'Photography Contest - Urban Life',
                'description' => 'Capture the essence of urban life in your city',
                'rules' => '1. Original photograph only
                            2. Taken within last 3 months
                            3. No heavy editing
                            4. RAW or High-res JPG',
                'reward' => 3000000,
                'deadline' => Carbon::now()->addDays(45),
                'status' => 'active',
            ],

            // Pending Challenge by Budi (curator_id: 2)
            [
                'curator_id' => 2,
                'title' => '3D Character Design Challenge',
                'description' => 'Design a unique 3D character for game development',
                'rules' => '1. Must be game-ready model
                            2. Poly count: max 50k tris
                            3. Include texture files
                            4. Format: FBX or OBJ',
                'reward' => 7000000,
                'deadline' => Carbon::now()->addDays(60),
                'status' => 'pending',
            ],

            // Ended Challenge by Siti (curator_id: 3)
            [
                'curator_id' => 3,
                'title' => 'Illustration Challenge - Folklore',
                'description' => 'Illustrate Indonesian folklore characters',
                'rules' => '1. Based on Indonesian folklore
                            2. Original interpretation
                            3. Digital or traditional
                            4. High resolution required',
                'reward' => 4000000,
                'deadline' => Carbon::now()->subDays(10),
                'status' => 'ended',
            ],
        ];

        foreach ($challenges as $challenge) {
            Challenge::create($challenge);
        }

        $this->command->info('Challenges seeded successfully!');
    }
}