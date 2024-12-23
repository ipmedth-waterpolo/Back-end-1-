<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Oefening;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Voeg gebruikers toe
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('Passw0rd'),
        ]);

        User::create([
            'name' => 'Trainer User',
            'email' => 'trainer@example.com',
            'role' => 'trainer',
            'password' => bcrypt('TrainerPass'),
        ]);

        // Call your seeders here
        $this->call([
            OefeningenSeeder::class,
            TrainingSeeder::class,
        ]);
    }
}
