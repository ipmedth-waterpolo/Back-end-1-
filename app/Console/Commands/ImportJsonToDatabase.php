<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Oefening;

class ImportJsonToDatabase extends Command
{
    protected $signature = 'import:json-to-database';
    protected $description = 'Importeer meerdere JSON-bestanden naar de database';

    public function handle()
    {
        $jsonFiles = [
            'fysiofabriek.json',
            'waterpoloplanet.json',
        ];

        foreach ($jsonFiles as $fileName) {
            $jsonPath = storage_path("app/$fileName");

            if (!file_exists($jsonPath)) {
                $this->error("JSON-bestand '$fileName' niet gevonden");
                continue; 
            }

            $jsonData = json_decode(file_get_contents($jsonPath), true);

            if (!$jsonData) {
                $this->error("Fout bij het decoderen van JSON in '$fileName'");
                continue; 
            }

            foreach ($jsonData as $oefening) {
                $afbeeldingen = null;

                // Controleer of de afbeelding bestaat en valideer deze
                if (isset($oefening['plaatje']) && isset($oefening['plaatje']['url'])) {
                    $afbeeldingen = json_encode(['url' => $oefening['plaatje']['url']]);
                }

                // Voeg de oefening toe aan de database
                Oefening::create([
                    'name' => $oefening['titel'],
                    'categorie' => json_encode($oefening['Categorie']),
                    'onderdeel' => json_encode($oefening['Onderdeel']),
                    'leeftijdsgroep' => json_encode($oefening['Leeftijd']),
                    'duur' => $oefening['Duur (min)'],
                    'minimum_aantal_spelers' => $oefening['min_spelers'],
                    'benodigdheden' => json_encode($oefening['Benodigdheden']),
                    'water_nodig' => $oefening['Wateroefening'] ? 1 : 0,
                    'omschrijving' => $oefening['Omschrijving'],
                    'source' => $oefening['Bron_url'],
                    'afbeeldingen' => $afbeeldingen, // JSON-object of null
                ]);
            }

            $this->info("JSON-gegevens van '$fileName' succesvol geïmporteerd!");
        }

        $this->info('Alle JSON-bestanden zijn verwerkt!');
    }
}
