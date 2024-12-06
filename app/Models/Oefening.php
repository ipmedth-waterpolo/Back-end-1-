<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oefening extends Model
{
    use HasFactory;

    protected $table = 'oefening';

    protected $fillable = [
        'name', 
        'categorie', 
        'onderdeel', 
        'leeftijdsgroep', 
        'duur', 
        'minimum_aantal_spelers', 
        'benodigdheden', 
        'water_nodig', 
        'omschrijving', 
        'source', 
        'afbeeldingen', 
        'videos', // Ensure videos are also in the fillable array if you're handling them
    ];

    // Add the casts property to handle JSON fields correctly
    protected $casts = [
        'leeftijdsgroep' => 'array',   // Cast leeftijdsgroep to an array
        'afbeeldingen' => 'array',     // Cast afbeeldingen to an array
        'videos' => 'array',           // Cast videos to an array
    ];
}

