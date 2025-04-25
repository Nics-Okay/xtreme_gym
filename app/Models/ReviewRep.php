<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRep extends Model
{
    use HasFactory;

    protected $table = 'review_reps';

    protected $fillable = [
        'review_id',
        'admin_id',
        'reply',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}