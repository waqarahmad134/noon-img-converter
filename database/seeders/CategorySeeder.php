<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Indian Movies',
            'Hindi Dubbed Movies',
            'Punjabi',
            'English',
            'Movies by Actors',
            'Movies by Actress',
            'By Type',
            'Show / Series',
        ];

        foreach ($categories as $categoryName) {
            $category = Category::where('name', $categoryName)->first();
            if ($category) {
                $this->command->info($categoryName . ' already exists!');
            } else {
                Category::create([
                    'name' => $categoryName,
                ]);
                $this->command->info($categoryName . ' seeded successfully!');
            }
        }
    }
}
