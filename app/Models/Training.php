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
        'ratings',
    ];

    // Zorg ervoor dat oefeningIDs automatisch als array worden behandeld
    protected $casts = [
        'oefeningIDs' => 'string', // Hierdoor wordt JSON automatisch omgezet naar een array
    ];

    public function reviews()
    {
        return $this->hasMany(Rating::class, 'trainingID');
    }

    public function averageRating()
    {
        return round($this->reviews()->avg('ratingNumber'), 1);
    }
}
