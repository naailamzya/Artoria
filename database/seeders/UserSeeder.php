<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin Artoria',
            'email' => 'admin@artoria.com',
            'display_name' => 'Artoria Admin',
            'bio' => 'Platform administrator managing the creative community.',
        ]);

        User::factory()->curator()->count(5)->create();

        User::factory()->pendingCurator()->count(3)->create();

        User::factory()->member()->count(30)->create();

        $this->command->info('Users seeded successfully!');
    }
}