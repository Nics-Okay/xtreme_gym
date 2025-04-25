<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'class_id',
        'student_until',
        'attended',
        'status',
        'payment_status',
        'payment_method',
    ];

    public function classList()
    {
        return $this->belongsTo(ClassList::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'unique_id');
    }
}
