<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Oefening;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);
    

    Oefening::create([
        'name' => 'Test Oefening',
        'categorie' => json_encode(['categorie1']),
        'onderdeel' => json_encode(['onderdeel1']),
        'leeftijdsgroep' => json_encode(['O10']),
        'duur' => 10,
        'minimum_aantal_spelers' => 2,
        'benodigdheden' => json_encode(['bal']),
        'water_nodig' => 1,
        'omschrijving' => 'Test beschrijving',
        'source' => 'http://example.com',
        'afbeeldingen' => json_encode(['url' => 'http://example.com/image.png']),
    ]);

}
}