<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'tournament_id',
        'game_date',
        'winner_name',
        'winner_score',
        'defeated_score',
        'defeated_name',
        'participant_id',
        'rank',
        'remarks'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}