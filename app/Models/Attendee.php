<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $table = 'attendees';

    protected $fillable = [
        'user_id',
        'name',
        'membership_type',
        'membership_status',
        'membership_validity',
        'time_in',
        'time_out',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }
}
