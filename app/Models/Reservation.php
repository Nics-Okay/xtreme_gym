<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'user_id',
        'color',
        'name',
        'email',
        'number',
        'address',
        'reservation_type',
        'reservation_date',
        'start_time',
        'end_time',
        'status',
        'number_of_people',
        'payment_status',
        'cancellation_reason',
    ];
}
