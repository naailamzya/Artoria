<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\Artwork;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $reporters = User::where('role', 'member')->limit(10)->get();
        
        $artworks = Artwork::inRandomOrder()->limit(5)->get();
        foreach ($artworks as $artwork) {
            Report::factory()->create([
                'reporter_id' => $reporters->random()->id,
                'reportable_type' => Artwork::class,
                'reportable_id' => $artwork->id,
            ]);
        }

        $comments = Comment::inRandomOrder()->limit(5)->get();
        foreach ($comments as $comment) {
            Report::factory()->create([
                'reporter_id' => $reporters->random()->id,
                'reportable_type' => Comment::class,
                'reportable_id' => $comment->id,
            ]);
        }

        $this->command->info('Reports seeded successfully!');
    }
}