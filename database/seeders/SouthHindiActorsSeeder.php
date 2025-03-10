<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Actor;

class SouthHindiActorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $southHindiActors = [
            'Rajinikanth',
            'Kamal Haasan',
            'Prabhas',
            'Mahesh Babu',
            'Allu Arjun',
            'NTR Jr.',
            'Rana Daggubati',
            'Vijay Deverakonda',
            'Dhanush',
            'Vikram',
            'Suriya',
            'Jr. NTR',
            'Ram Charan',
            'Siddharth',
            'Nani',
            'Yash',
            'Ravi Teja',
            'Sudeep',
            'Nivin Pauly',
            'Dulquer Salmaan',
        ];

        foreach ($southHindiActors as $actorName) {
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
