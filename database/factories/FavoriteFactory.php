<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Artwork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Favorite>
 */
class FavoriteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'artwork_id' => Artwork::factory(),
        ];
    }
}