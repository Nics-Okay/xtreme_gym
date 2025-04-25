<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassList extends Model
{
    use HasFactory;

    protected $table = 'class_lists';

    protected $fillable = [
        'name',
        'trainer',
        'schedule',
        'duration',
        'class_start',
        'class_end',
        'status',
        'number_of_students',
        'price',
        'description',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }
}
