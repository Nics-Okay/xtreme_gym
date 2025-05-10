<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityList extends Model
{
    use HasFactory;

    protected $table = 'facility_lists';

    protected $fillable = [
        'name',
        'hourly_rate',
        'max_capacity',
        'open_time',
        'close_time',
        'status',
        'description',
    ];
}
