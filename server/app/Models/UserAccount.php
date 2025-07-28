<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class UserAccount extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'user_accounts';

    protected $fillable = [
        'account',
        'password',
        'login_time',
        'logout_time',
        'login_ip',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'login_time' => 'datetime',
        'logout_time' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
