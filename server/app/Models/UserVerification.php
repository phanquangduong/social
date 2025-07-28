<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserVerification extends Model
{
    use HasFactory;

    protected $table = 'user_verifications';

    protected $fillable = [
        'otp',
        'key',
        'key_hash',
        'is_verified',
        'is_deleted',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_deleted' => 'boolean',
        'type' => 'integer',
    ];
}
