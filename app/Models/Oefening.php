<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oefening extends Model
{
    use HasFactory;

    // Specify the table associated with the model
    protected $table = 'oefening';

    // Define fillable fields to allow mass assignment
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
        'variatie',    // Added variatie since it was in the migration
        'source',
        'afbeeldingen',
        'videos',
        'rating',
        'icon',
        'rating',      // Included rating for completeness
    ];

    /**
     * Automatically cast fields to specific data types.
     * This ensures JSON fields are returned as arrays and booleans are handled correctly.
     */
    protected $casts = [
        'categorie' => 'array',
        'onderdeel' => 'array',
        'benodigdheden' => 'array',
        'leeftijdsgroep' => 'array',   // Automatically handle as array
        'afbeeldingen' => 'array',    // Automatically handle as array
        'videos' => 'array',          // Automatically handle as array
        'water_nodig' => 'boolean',   // Ensure boolean handling
        'enabled' => 'boolean',       // Enabled field cast to boolean if needed
        'rating' => 'integer',        // Ensure rating is an integer
    ];

    // Many-to-many relationship with Training
    public function trainings()
    {
        return $this->belongsToMany(Training::class, 'oefening_training', 'oefening_id', 'training_id')
                    ->withTimestamps();
    }
}
