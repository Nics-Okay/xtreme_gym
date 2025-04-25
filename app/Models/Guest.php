<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $table = 'guests';

    protected $fillable = [
        'unique_id',
        'email',
        'first_name',
        'last_name',
        'phone',
        'address',
        'payment_method',
        'is_in_gym',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($guest) {
            $prefix = 'G'; 
            $date = now()->format('Ymd'); 
            $lastGuest = static::where('unique_id', 'like', "$prefix$date%")->latest()->first();

            $sequence = $lastGuest ? (int) substr($lastGuest->unique_id, -3) + 1 : 1;
            $sequenceFormatted = str_pad($sequence, 3, '0', STR_PAD_LEFT);

            $guest->unique_id = "$prefix$date$sequenceFormatted";
        });
    }
}
