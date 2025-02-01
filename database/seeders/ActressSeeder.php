<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actress;

class ActressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actresses = [
            'Deepika Padukone',
            'Priyanka Chopra',
            'Kangana Ranaut',
            'Alia Bhatt',
            'Anushka Sharma',
            'Kareena Kapoor Khan',
            'Katrina Kaif',
            'Shraddha Kapoor',
            'Sonam Kapoor',
            'Jacqueline Fernandez',
            'Madhuri Dixit',
            'Vidya Balan',
            'Taapsee Pannu',
            'Anushka Shetty',
            'Tamannaah Bhatia',
            'Nayanthara',
            'Rashmika Mandanna',
            'Keerthy Suresh',
            'Samantha Akkineni',
            'Pooja Hegde',
        ];

        foreach ($actresses as $actressName) {
            $actress = Actress::where('name', $actressName)->first();
            if ($actress) {
                $this->command->info($actressName . ' already exists!');
            } else {
                Actress::create([
                    'name' => $actressName,
                ]);
                $this->command->info($actressName . ' seeded successfully!');
            }
        }
    }
}
