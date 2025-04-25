<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_contact',
        'title',
        'message',
        'category',
        'payment_method',
        'prority',
        'submitted_at',
        'resolved_at',
        'is_read',
    ];
}
