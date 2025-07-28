<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    protected $table = 'refresh_tokens';

    protected $fillable = [
        'user_account_id',
        'token',
        'revoked',
        'expires_at',
    ];

    protected $casts = [
        'revoked' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class);
    }
}
