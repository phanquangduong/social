<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Models\RefreshToken;
use DateTime;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function revokeByUserId(int $userId): void
    {
        RefreshToken::where('user_account_id', $userId)
            ->where('revoked', false)
            ->update(['revoked' => true]);
    }

    public function store(int $userId, string $token, DateTime $expiresAt): void
    {
        RefreshToken::create([
            'user_account_id' => $userId,
            'token'      => $token,
            'expires_at' => $expiresAt,
            'revoked'    => false,
        ]);
    }

    public function findValidRefreshToken(string $token): ?RefreshToken
    {
        return RefreshToken::where('token', $token)
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->first();
    }
}
