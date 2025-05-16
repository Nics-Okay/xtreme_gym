<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $table = 'tournaments';

    protected $fillable = [
        'name',
        'type',
        'tournament_date',
        'registration_fee',
        'first_prize',
        'second_prize',
        'third_prize',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    public function participants()
    {
    return $this->hasMany(Participant::class, 'tournament_id');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
