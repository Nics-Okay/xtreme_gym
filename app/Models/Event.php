<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'image',
        'name',
        'event_type',
        'date',
        'location',
        'status',
        'description',
        'going',
        'organizer',
    ];
}
