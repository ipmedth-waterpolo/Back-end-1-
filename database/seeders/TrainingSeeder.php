<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $trainings = [
            [
                'name' => 'Beginner Waterpolo Training',
                'beschrijving' => 'Een complete training voor beginners die zich richten op basistechnieken en conditie.',
                'totale_duur' => 60,
                'oefeningIDs' => [1, 2, 3], // Assuming these match the IDs from your oefening table
                'userID' => 1, // Assuming user ID 1 is valid
                'enabled' => true,
            ],
            [
                'name' => 'Gevorderde Techniek Training',
                'beschrijving' => 'Een training voor gevorderden, met focus op tactiek en samenwerking.',
                'totale_duur' => 90,
                'oefeningIDs' => [4, 5, 6],
                'userID' => 2,
                'enabled' => true,
            ],
            [
                'name' => 'Conditie en Cardio Boost',
                'beschrijving' => 'Intensieve training gericht op het verbeteren van conditie en snelheid in het water.',
                'totale_duur' => 45,
                'oefeningIDs' => [7, 8, 9],
                'userID' => 1,
                'enabled' => false,
            ],
        ];

        foreach ($trainings as $training) {
            Training::create($training);
        }
    }
}
