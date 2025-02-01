<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;

class ActorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actors = [
            'Amitabh Bachchan',
            'Shah Rukh Khan',
            'Salman Khan',
            'Aamir Khan',
            'Rajinikanth',
            'Kamal Haasan',
            'Hrithik Roshan',
            'Akshay Kumar',
            'Ranbir Kapoor',
            'Ajay Devgn',
            'Saif Ali Khan',
            'Varun Dhawan',
            'Ranveer Singh',
            'Vijay Deverakonda',
            'Prabhas',
            'Mahesh Babu',
            'Allu Arjun',
            'NTR Jr.',
            'Dulquer Salmaan',
            'Nivin Pauly',
        ];

        foreach ($actors as $actorName) {
            $actor = Actor::where('name', $actorName)->first();
            if ($actor) {
                $this->command->info($actorName . ' already exists!');
            } else {
                Actor::create([
                    'name' => $actorName,
                ]);
                $this->command->info($actorName . ' seeded successfully!');
            }
        }
    }
}
