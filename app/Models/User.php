<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function Ramsey\Uuid\v1;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'unique_id',
        'user_type',
        'email',
        'first_name',
        'last_name',
        'nickname',
        'phone',
        'password',
        'address',
        'occupation',
        'emergency_contact_name',
        'emergency_contact_number',
        'image',
        'admin_code',
        'otp_code',
        'otp_expires_at',
        'otp_verified',
        'membership_type',
        'membership_status',
        'membership_validity',
        'renewal_count',
        'visits',
        'active_hours',
        'membership_hours',
        'is_in_gym',
    ];     /** Required: first_name, password */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $prefix = 'XGW'; 
            $date = now()->format('Ymd'); 
            $lastUser = static::where('unique_id', 'like', "$prefix$date%")->latest()->first();

            $sequence = $lastUser ? (int) substr($lastUser->unique_id, -3) + 1 : 1;
            $sequenceFormatted = str_pad($sequence, 3, '0', STR_PAD_LEFT);

            $user->unique_id = "$prefix$date$sequenceFormatted";
        });
    }
}
