<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $table = 'trainers';

    protected $fillable = [
        'name',
        'user_id',
        'specialization',
        'phone',
        'availability',
        'students',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }
}
