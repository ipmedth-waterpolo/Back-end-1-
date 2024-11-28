<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oefening extends Model
{
    use HasFactory;

    protected $table = 'oefening';

    protected $fillable = [
        'name', 'categorie', 'onderdeel', 'leeftijdsgroep', 'duur', 
        'minimum_aantal_spelers', 'benodigdheden', 'water_nodig', 
        'omschrijving', 'source', 'afbeeldingen',
    ];
}
