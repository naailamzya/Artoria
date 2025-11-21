<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            UserSeeder::class,
            ArtworkSeeder::class,
            ChallengeSeeder::class,
            InteractionSeeder::class,
            ChallengeSubmissionSeeder::class,
            ChallengeWinnerSeeder::class,
        ]);
        
        $this->command->info('Database seeded successfully!');
    }
}