<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SuperAdminSeed::class,
            CategorySeeder::class,
            ActorSeeder::class,
            ActressSeeder::class,
            SouthHindiActorsSeeder::class,
            MovieQualitySeeder::class,
        ]);
    }
}
