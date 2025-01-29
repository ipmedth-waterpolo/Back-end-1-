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
                'omschrijving' => "Voer alle oefeningen gedurende 30 seconden uit. Let erop dat je indien van toepassing zowel de oefening voor links als rechts doet voordat je met de volgende oefening verder gaat. Hieronder een korte beschrijving van alle oefeningen.\n\n#1 Ja knikken\nJa natuurlijk beginnen we bovenaan bij de nek. Probeer je kin zover mogelijk richting je borst te krijgen.\n\n#2 Nee schudden\nNee hè, wanneer gaan we door met de echt interessante gewrichten? Eerst nog even 30 seconden van links naar rechts kijken om je nek maximaal soepel te krijgen.\n\n#3 Zwaaien voor\nYes, eindelijk! De schouder. Het o zo belangrijke gewricht dat ervoor zorgt dat je kan zwemmen en de bal met een vernietigende uithaal in de kruising doet laten belanden.\n\n#4 Zwaaien achter\nWe blijven nog even bij de schouder met draaien naar achteren. Een soepele schouder raakt minder snel geblesseerd. Overigens, meer lezen over schouderblessures bij waterpolo doe je hier.\n\n#5 Bram’s beweging\nOm je schouder optimaal te laten bewegen, moet ook de overgang van je nek naar je bovenrug soepel zijn. Bram weet dit, en doet daarom met verve zijn beweging, ook wel L-rotaties genaamd. Wees als Bram en doe ze 30 seconden naar links en rechts.\n\n#6 Draaien maar\nDanique draait haar hele rug los met deze oefening. De onderrug is de belangrijke schakel die de kracht die je heup genereert doorgeeft naar je schouder.\n\n#7 De windmolen\nMeer lage rug in de vorm van de windmolen. Als ie nou niet los is…\n\n#8 Soepele heup\nJe hebt soepele heupen nodig om goed te kunnen zwemmen. Hoe groter de range of motion in je heup, hoe groter het potentieel bereik waarbinnen je kracht kunt leveren.\n\n#9 De benenstrekker\nWe dalen verder af in de beweegketen die je lichaam heet en komen bij de hamstrings uit. Bij veel mensen voelen ze stijf aan, maar na deze oefening vast niet meer! Sommigen passen deze move toe op de dansvloer, maar wij weten wel beter.\n\n#10 Roeien (met de dynaband die je hebt)\nOf nog niet hebt. De dynaband oefeningen zijn overigens pas vanaf 12 jaar van toepassing. Met deze roei oefening jaag je alvast wat doorbloeding door je lats, oftewel je grote zwemspier.\n\n#11 Omgekeerd gooien\nNog meer doorbloeding, maar dan voor de achterkant van je schouder. Probeer een zuivere rotatie te maken waarbij je elleboog om dezelfde denkbeeldige as draait.\n\n#12 Duw! En span je buikspieren aan\nOok wel genaamd de Pallof press (vernoemd naar een zekere meneer Pallof die deze oefening heeft uitgevonden). Een antirotatie oefening, waarmee je je buikspieren op spanning zet en deze voorbereidt op hun taak om een stabiele romp te creëren en daarbij te zorgen voor een optimale krachtoverdracht.",
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
                'omschrijving' => "Een uitstekende allround conditietraining, vooral voor de buik- en rugspieren.\n\nProcedure:\n1. Maak tweetallen in diep water.\n2. Laat partners hun handen op elkaars schouders plaatsen, met gestrekte ellebogen.\n3. Wanneer ze klaar zijn, zegt de ene partner 'klaar'; wanneer de ander 'klaar' antwoordt, proberen ze elkaar onder te dompelen.\n4. Zodra 1 partner wordt ondergedompeld, is de match voorbij.\n5. Ga door voor de beste 2 van 3 wedstrijden.\n6. De oefening kan worden uitgevoerd als een eliminatiewedstrijd waarbij winnaars en verliezers tegen elkaar worden gepaard.\n\nVariatie:\nPlaats een hand op elkaars hoofd en gebruik de andere arm voor extra ondersteuning in het water.",
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
                'omschrijving' => "Een uitstekende oefening om adem inhouden te trainen en om te leren snel lucht te happen.\n\nProcedure:\n1. Maak tweetallen van spelers in diep water, waarbij ze elkaar met de vingers vasthouden terwijl ze elkaar aankijken.\n2. Een partner duikt onder totdat hij een gestrekte armpositie bereikt (ongeveer ter hoogte van de knie van de andere partner).\n3. De ondergedompelde partner trekt zijn maat onder water, terwijl hij zelf naar boven komt voor een ademteug.\n4. Versnel het tempo, waardoor ademen moeilijk wordt.\n5. Herhaal dit 10-25 keer.",
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
                'omschrijving' => "Oefening om onder stres de bal snel en nauwkeurig te gooien en meteen klaar te staan om de bal te ontvangen.\n\nProcedure:\n1. Rangschik de spelers in verschillende groepen verspreid rond het zwembad (5 of 6 per groep); 1 bal per groep.\n2. De spelers vormen een redelijk kleine cirkel en beginnen de bal rond en door de cirkel naar elkaar te passen, waarbij ze proberen de bal niet te lang vast te houden.\n3. De coach blaast af en toe op een fluitje. De speler met de bal, of degene die de bal als laatste heeft de bal aangeraakt, moet de cirkel verlaten en een lengte van het zwembad zwemmen (naar de overkant en terug), terwijl de anderen doorgaan met het passen van de bal en anticiperen op het volgende fluitje.\n\nVariatie:\nElke groep telt het aantal passes dat voltooid is zonder de bal te laten vallen. Als het fluitsignaal gaat, zwemt (of sprint) de hele groep met het laagste aantal passes een lengte van het zwembad zwemmen (naar de overkant en terug).",
                'source' => "http://www.waterpoloplanet.com/HTML_Bill_Pages/01_drill_for_gold_bill.html",
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_2.03_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],

            [
                'name' => 'Luister naar de hand',
                'enabled' => true,
                'categorie' => json_encode(['theorie', 'tactiek']),
                'onderdeel' => json_encode(['regels', 'handgebaren-scheidsrechter', 'heads-up']),
                'leeftijdsgroep' => json_encode(['O08', 'O10', 'O12', 'O14', 'O16', 'O18']),
                'duur' => 5,
                'minimum_aantal_spelers' => 2,
                'benodigdheden' => json_encode(['fluitje', 'bal per paar (optioneel)']),
                'water_nodig' => true,
                'omschrijving' => 'Oefening om de spelers te leren om alert te zijn op situaties waarin de scheidsrechter het spel stopt door op zijn fluit te blazen. Een speler moet niet alleen leren de fluit te respecteren en gehoorzamen en altijd weten waar de bal is. Voor de hogere leeftijdscategorieën komt daar een tactisch element bij: de speler kan ook op de beslissing anticiperen en onmiddellijk dienovereenkomstig handelen. Dit staat bekend als "heads up" waterpolo en stelt de speler in staat een voorsprong te krijgen op zijn tegenstander of zich snel te herstellen in een verdedigende situatie. Dit scherpe reactievermogen kan worden aangescherpt met de vlag-oefening. Vergeet niet om ook de neutrale worp, of face-off tussen twee spelers, te oefenen. Strafschoten en sprints naar de bal bij de eerste inworp van de scheidsrechter kunnen ook op het fluitsignaal worden geoefend. Procedure: Alle teamleden worden aan 1 kant van het zwembad per paar opgesteld. Elk paar is 1 speler aanval, de ander verdediging. De coach staat of loopt langs de kant van het zwembad. Eén kant van het zwembad wordt aangewezen als het witte doel, de andere kant als het blauwe doel. Op het fluitsignaal beginnen de spelers te zwemmen (met het hoofd omhoog) naar het doel aan de overkant. Je kan de aanvaller een bal geven voor extra moeilijkheid. Wanneer de fluit klinkt, moeten ze onmiddellijk naar de hand van de coach kijken en dienovereenkomstig reageren in de juiste richting.',
                'source' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/55_drill_for_gold_bill.html',
                'afbeeldingen' => json_encode(['url' => 'http://www.waterpoloplanet.com/HTML_Bill_Pages/images/drill_10.01_diagram.gif']),
                'videos' => null,
                'rating' => null,
            ],
            [
                'name' => 'Allround Warming-up',
                'enabled' => true,
                'categorie' => json_encode(['Warming Up']),
                'onderdeel' => json_encode(['rekken']),
                'leeftijdsgroep' => json_encode(['O10', 'O12', 'O14', 'O16', 'O18', 'volwassenen']),
                'duur' => 10,
                'minimum_aantal_spelers' => 1,
                'benodigdheden' => json_encode(['dynaband (voor O12 en ouder)']),
                'water_nodig' => false,
                'omschrijving' => 'Voer alle oefeningen gedurende 30 seconden uit. Let erop dat je indien van toepassing zowel de oefening voor links als rechts doet voordat je met de volgende oefening verder gaat. Hieronder een korte beschrijving van alle oefeningen: 1. Ja knikken: Probeer je kin zover mogelijk richting je borst te krijgen. 2. Nee schudden: Kijk van links naar rechts om je nek soepel te maken. 3. Zwaaien voor: Draai je schouder naar voren. 4. Zwaaien achter: Draai je schouder naar achteren. 5. Bram\'s beweging: Maak L-rotaties voor je bovenrug. 6. Draaien maar: Draai je hele rug los. 7. De windmolen: Maak windmolenbewegingen met je lage rug. 8. Soepele heup: Beweeg je heupen om ze soepel te maken. 9. De benenstrekker: Rek je hamstrings. 10. Roeien (met dynaband): Gebruik een dynaband voor doorbloeding van je spieren. 11. Omgekeerd gooien: Maak rotaties met je schouder. 12. Duw! En span je buikspieren aan: Een antirotatie oefening voor je buikspieren. 13. Schouderliefde: Geef je schouder extra doorbloeding. Nu weet je hoe je je lichaam snel en efficiënt opwarmt voordat je het water induikt.',
                'source' => 'https://fysiofabriek.nl/blog/waterpolo-warming-up/',
                'afbeeldingen' => null,
                'videos' => json_encode(['url' => 'https://vimeo.com/357051379']),
                'rating' => null,
            ],


        ];

        DB::table('oefening')->insert($oefening);
    }
}
