<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OefeningenSeeder extends Seeder
{
    public function run()
    {
        $oefening = [
            [
                'name' => 'allround Warming-up',
                'enabled' => true,
                'categorie' => json_encode(["Warming Up"]),
                'onderdeel' => json_encode(["rekken"]),
                'leeftijdsgroep' => json_encode(["O10", "O12", "O14", "O16", "O18", "volwassenen"]),
                'duur' => 10,
                'minimum_aantal_spelers' => 1,
                'benodigdheden' => json_encode(["dynaband(voor O12 en ouder)"]),
                'water_nodig' => false,
                'omschrijving' => "<div><p>Voer alle oefeningen...</p></div>",
                'source' => "https://fysiofabriek.nl/blog/waterpolo-warming-up/",
                'afbeeldingen' => null,
                'videos' => json_encode(['url' => 'https://vimeo.com/357051379']),
                'rating' => null,
            ],
            [
                'name' => "Wedstrijdje onderduwen",
                'enabled' => true,
                'categorie' => json_encode(["conditie", "tactiek"]),
                'onderdeel' => json_encode(["spieren", "verdediging"]),
                'leeftijdsgroep' => json_encode(["O10", "O12", "O14", "O16", "O18"]),
                'duur' => 5,
                'minimum_aantal_spelers' => 2,
                'benodigdheden' => json_encode([]),
                'water_nodig' => true,
                'omschrijving' => "<div>Een uitstekende allround...</div>",
                'source' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/01_drill_for_gold_bill.html",
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_1.01_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],
            [
                'name' => "Lucht happen en ondertrekken",
                'enabled' => true,
                'categorie' => json_encode(["conditie", "tactiek"]),
                'onderdeel' => json_encode(["ademhaling", "aanval"]),
                'leeftijdsgroep' => json_encode(["O12", "O14", "O16", "O18"]),
                'duur' => 5,
                'minimum_aantal_spelers' => 2,
                'benodigdheden' => json_encode([]),
                'water_nodig' => true,
                'omschrijving' => "<div>Een uitstekende oefening...</div>",
                'source' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/01_drill_for_gold_bill.html",
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_1.01_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],
            [
                'name' => "Hete aardappel",
                'enabled' => true,
                'categorie' => json_encode(["conditie", "techniek", "tactiek"]),
                'onderdeel' => json_encode(["cardio", "gooien-vangen", "wedstrijdstress"]),
                'leeftijdsgroep' => json_encode(["O12", "O14", "O16", "O18"]),
                'duur' => 10,
                'minimum_aantal_spelers' => 5,
                'benodigdheden' => json_encode(["1 bal per groep", "fluitje"]),
                'water_nodig' => true,
                'omschrijving' => "<div>Oefening om onder stres...</div>",
                'source' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/12_drill_for_gold_bill.html",
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_2.03_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],
            [
                'name' => "Luister naar de hand",
                'enabled' => true,
                'categorie' => json_encode(["theorie", "tactiek"]),
                'onderdeel' => json_encode(["regels", "handgebaren-scheidsrechter", "heads-up"]),
                'leeftijdsgroep' => json_encode(["O08", "O10", "O12", "O14", "O16", "O18"]),
                'duur' => 5,
                'minimum_aantal_spelers' => 2,
                'benodigdheden' => json_encode(["fluitje", "bal per paar (optioneel)"]),
                'water_nodig' => true,
                'omschrijving' => "<div>Oefening om de spelers te leren...</div>",
                'source' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/55_drill_for_gold_bill.html",
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_10.01_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],
        ];

        DB::table('oefening')->insert($oefening);
    }

}
