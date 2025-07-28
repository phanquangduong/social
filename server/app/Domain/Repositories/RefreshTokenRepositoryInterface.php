<?php

namespace App\Domain\Repositories;

use App\Models\RefreshToken;
use DateTime;

interface RefreshTokenRepositoryInterface
{
    public function revokeByUserId(int $userId): void;

    public function store(int $userId, string $token, DateTime $expiresAt): void;

    public function findValidRefreshToken(string $token): ?RefreshToken;
}
