<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'name',
        'payment_method',
        'transaction_type',
        'payment_code',
        'amount',
        'status',
        'discounts',
        'processed_by',
        'remarks',
    ];

    public function rate()
    {
        return $this->belongsTo(Rate::class, 'payment_code', 'id');
    }

    public function class_list()
    {
        return $this->belongsTo(ClassList::class, 'payment_code', 'id');
    }

    public function training()
    {
        return $this->belongsTo(Training::class, 'payment_code', 'id');
    }
}
