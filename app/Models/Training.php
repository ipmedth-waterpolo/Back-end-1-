<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'training';

    protected $fillable = [
        'name',
        'beschrijving',
        'totale_duur',
        'oefeningIDs',
        'userID',
        'enabled',
    ];

    // Zorg ervoor dat oefeningIDs automatisch als array worden behandeld
    protected $casts = [
        'oefeningIDs' => 'array', // JSON wordt automatisch omgezet naar een array
    ];

    /**
     * Relatie met de Rating
     */
    public function reviews()
    {
        return $this->hasMany(Rating::class, 'trainingID');
    }

    /**
     * Berekent de gemiddelde rating
     */
    public function averageRating()
    {
        $average = $this->reviews()->avg('ratingNumber');
        return $average ? round($average, 1) : null; // Geeft null terug als er geen ratings zijn
    }

    /**
     * Relatie met de User (Eigenaar van de training)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    /**
     * Relatie met oefeningen
     */
    public function oefeningen()
    {
        // Return related exercises using the 'oefeningIDs' field
        return $this->belongsToMany(Oefening::class, 'oefening_training', 'training_id', 'oefening_id')
                    ->withTimestamps();
    }
}
