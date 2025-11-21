<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Favorite;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class InteractionSeeder extends Seeder
{
    public function run(): void
    {
        $likes = [
            ['user_id' => 4, 'artwork_id' => 3], // Andi likes Dewi's work
            ['user_id' => 4, 'artwork_id' => 5], // Andi likes Rudi's work
            ['user_id' => 5, 'artwork_id' => 1], // Dewi likes Andi's work
            ['user_id' => 5, 'artwork_id' => 7], // Dewi likes Maya's work
            ['user_id' => 6, 'artwork_id' => 9], // Rudi likes Fajar's work
            ['user_id' => 7, 'artwork_id' => 2], // Maya likes Andi's work
            ['user_id' => 8, 'artwork_id' => 4], // Fajar likes Dewi's work
        ];

        foreach ($likes as $like) {
            Like::create($like);
        }

        $favorites = [
            ['user_id' => 4, 'artwork_id' => 3],
            ['user_id' => 4, 'artwork_id' => 7],
            ['user_id' => 5, 'artwork_id' => 1],
            ['user_id' => 6, 'artwork_id' => 9],
            ['user_id' => 7, 'artwork_id' => 4],
        ];

        foreach ($favorites as $favorite) {
            Favorite::create($favorite);
        }

        $comments = [
            [
                'user_id' => 5,
                'artwork_id' => 1,
                'comment' => 'Amazing color palette! Love the gradient.',
            ],
            [
                'user_id' => 4,
                'artwork_id' => 3,
                'comment' => 'The lighting in this 3D scene is phenomenal!',
            ],
            [
                'user_id' => 6,
                'artwork_id' => 1,
                'comment' => 'This would make a great wallpaper!',
            ],
            [
                'user_id' => 7,
                'artwork_id' => 5,
                'comment' => 'Clean UI design, very modern!',
            ],
            [
                'user_id' => 8,
                'artwork_id' => 7,
                'comment' => 'Love the brand identity concept!',
            ],
            [
                'user_id' => 4,
                'artwork_id' => 9,
                'comment' => 'The character design is so creative!',
            ],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        $this->command->info('Interactions (Likes, Favorites, Comments) seeded successfully!');
    }
}