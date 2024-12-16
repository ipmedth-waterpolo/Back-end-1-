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
        'oefening_ids',
    ];

    protected $casts = [
        'oefening_ids' => 'array',
    ];
}
