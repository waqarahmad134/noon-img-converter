<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quality;

class MovieQualitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $qualities = [
            'HD',
            'SD',
            'Full HD',
            '4K Ultra HD',
            'Blu-ray',
            'DVD',
        ];

        foreach ($qualities as $qualityName) {
            $quality = Quality::where('name', $qualityName)->first();
            if ($quality) {
                $this->command->info($qualityName . ' already exists!');
            } else {
                Quality::create([
                    'name' => $qualityName,
                ]);
                $this->command->info($qualityName . ' seeded successfully!');
            }
        }
    }
}
