<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'tournament_id',
        'participant_id',
        'rank',
        'score',
        'remarks'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}