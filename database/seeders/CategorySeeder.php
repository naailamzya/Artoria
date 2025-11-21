<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Fotografi',
            'UI/UX',
            '3D Art',
            'Ilustrasi',
            'Graphic Design',
            'Character Design',
            'Animation',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }
        
        $this->command->info('Categories seeded successfully!');
    }
}
