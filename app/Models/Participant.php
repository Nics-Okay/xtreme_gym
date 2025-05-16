<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';

    protected $fillable = [
        'user_id',
        'tournament_id',
        'participant_name',
        'contact_details',
        'payment_method',
        'payment_status',
        'team_name'
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }
}
