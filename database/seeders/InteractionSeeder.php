<?php

namespace Database\Seeders;

use App\Models\Artwork;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $artworks = Artwork::all();
        $users = User::where('role', 'member')->get();

        foreach ($artworks as $artwork) {
            $likers = $users->random(rand(0, 20));
            foreach ($likers as $user) {
                $artwork->likes()->create(['user_id' => $user->id]);
            }

            $favoriters = $users->random(rand(0, 10));
            foreach ($favoriters as $user) {
                $artwork->favorites()->create(['user_id' => $user->id]);
            }

            $commenters = $users->random(rand(0, 8));
            foreach ($commenters as $user) {
                Comment::factory()->create([
                    'user_id' => $user->id,
                    'artwork_id' => $artwork->id,
                ]);
            }

            $artwork->update(['likes_count' => $artwork->likes()->count()]);
        }

        $this->command->info('Interactions seeded successfully!');
    }
}