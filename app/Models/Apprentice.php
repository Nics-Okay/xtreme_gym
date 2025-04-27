<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    use HasFactory;

    protected $table = 'apprentices';

    protected $fillable = [
        'user_id',
        'training_id',
        'student_until',
        'attended',
        'status',
        'payment_status',
        'payment_method',
    ];

    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }
}
