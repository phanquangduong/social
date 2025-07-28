<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_account_id',
        'name',
        'username',
        'avatar',
        'cover_image',
        'state',
        'gender',
        'birthday',
        'mobile',
        'email',
    ];

    protected $casts = [
        'birthday' => 'date',
        'state' => 'integer',
        'gender' => 'integer',
    ];

    public function userAccount()
    {
        return $this->belongsTo(UserAccount::class);
    }
}
