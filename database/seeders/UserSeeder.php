<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Artoria',
            'email' => 'admin@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'admin',
            'bio' => 'Platform administrator',
            'external_link' => 'https://artoria.com',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'curator',
            'bio' => 'Art curator specializing in digital art',
            'external_link' => 'https://instagram.com/budisantoso',
        ]);

        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'curator',
            'bio' => 'Curator for photography and visual arts',
            'external_link' => 'https://behance.net/sitinurhaliza',
        ]);

        User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'member',
            'bio' => 'Digital artist and illustrator',
            'external_link' => 'https://instagram.com/andipratama',
        ]);

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'member',
            'bio' => '3D artist and animator',
            'external_link' => 'https://artstation.com/dewilestari',
        ]);

        User::create([
            'name' => 'Rudi Hartono',
            'email' => 'rudi@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'member',
            'bio' => 'UI/UX designer and photographer',
            'external_link' => 'https://dribbble.com/rudihartono',
        ]);

        User::create([
            'name' => 'Maya Sari',
            'email' => 'maya@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'member',
            'bio' => 'Graphic designer and brand identity specialist',
            'external_link' => 'https://behance.net/mayasari',
        ]);

        User::create([
            'name' => 'Fajar Ramadhan',
            'email' => 'fajar@artoria.com',
            'password' => Hash::make('password'),
            'status' => 'member',
            'bio' => 'Character designer and concept artist',
            'external_link' => 'https://instagram.com/fajarramadhan',
        ]);

        $this->command->info('Users seeded successfully!');
        $this->command->info('Email: admin@artoria.com | Password: password');
        $this->command->info('Email: budi@artoria.com | Password: password (Curator)');
        $this->command->info('Email: andi@artoria.com | Password: password (Member)');
    }
}