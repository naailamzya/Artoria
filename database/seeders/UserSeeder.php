<?php

namespace Database\Seeders;

use App\Models\User;
use App\Helpers\ImageHelper;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $avatarCount = ImageHelper::getSampleImageCount('avatars');
        
        if ($avatarCount > 0) {
            $this->command->info("Found {$avatarCount} sample avatars!");
        } else {
            $this->command->warn("No sample avatars found. Will generate placeholders.");
            $this->command->info("Add images to: storage/app/public/samples/avatars/");
        }

        $this->command->info('Creating users with profile pictures...');

        $this->command->info('Creating admin...');
        $admin = User::factory()->admin()->create([
            'name' => 'Admin Artoria',
            'email' => 'admin@artoria.com',
            'display_name' => 'Artoria Admin',
            'bio' => 'Platform administrator managing the creative community.',
        ]);
        
        $admin->update(['profile_picture' => ImageHelper::getRandomAvatar()]);

        $this->command->info('Creating 5 active curators...');
        for ($i = 1; $i <= 5; $i++) {
            $this->command->info("  → Curator {$i}/5");
            $curator = User::factory()->curator()->create();
            $curator->update(['profile_picture' => ImageHelper::getRandomAvatar()]);
        }

        $this->command->info('Creating 3 pending curators...');
        for ($i = 1; $i <= 3; $i++) {
            $this->command->info("  → Pending curator {$i}/3");
            $curator = User::factory()->pendingCurator()->create();
            $curator->update(['profile_picture' => ImageHelper::getRandomAvatar()]);
        }

        $this->command->info('Creating 30 members...');
        for ($i = 1; $i <= 30; $i++) {
            if ($i % 5 === 0 || $i === 1) {
                $this->command->info("  → Member {$i}/30");
            }
            $member = User::factory()->member()->create();
            $member->update(['profile_picture' => ImageHelper::getRandomAvatar()]);
        }

        $this->command->info('Users created successfully with profile pictures!');
    }
}