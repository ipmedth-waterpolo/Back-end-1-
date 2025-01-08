<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'rating_review';

    protected $fillable = [
        'ratingNumber',
        'userID',
        'trainingID',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'trainingID');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }
}
