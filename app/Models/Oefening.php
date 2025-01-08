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
        'variatie',
        'source',
        'afbeeldingen',
        'videos',
        'rating',
        'icon',
    ];

    protected $casts = [
        'categorie' => 'array',
        'onderdeel' => 'array',
        'benodigdheden' => 'array',
        'leeftijdsgroep' => 'array',
        'afbeeldingen' => 'array',
        'videos' => 'array',
        'water_nodig' => 'boolean',
        'enabled' => 'boolean',
        'rating' => 'integer',
    ];

    // Many-to-many relationship with Training
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'oefening_training', 'oefening_id', 'training_id')
                    ->withTimestamps();
    }
}
