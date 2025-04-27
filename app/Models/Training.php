<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $table = 'trainings';

    protected $fillable = [
        'name',
        'trainer',
        'schedule',
        'duration',
        'status',
        'number_of_students',
        'price',
        'description',
    ];

    public function apprentices()
    {
        return $this->hasMany(Apprentice::class, 'class_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Trainer::class, 'trainer', 'name');
    }
}
