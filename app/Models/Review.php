<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'type',
        'rating',
        'comment',
    ];

    // Review belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A review can have multiple admin replies
    public function replies()
    {
        return $this->hasMany(ReviewRep::class, 'review_id');
    }
}