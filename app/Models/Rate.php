<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $table = 'rates';

    protected $fillable = [
        'name',
        'price',
        'color',
        'validity_value',
        'validity_unit',
        'times_availed',
        'description',
        'perks',
    ];
}
