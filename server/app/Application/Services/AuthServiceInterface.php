<?php

namespace App\Application\Services;

use App\Models\PasswordResetToken;
use App\Models\RefreshToken;
use App\Models\UserAccount;
use App\Models\UserVerification;

interface AuthServiceInterface
{
    public function generateSixDigitOtp(): string;

    public function hashPassword(string $value): string;

    public function checkPassword(string $plain, string $hashed): bool;

    public function generateSha256Hash(string $key): string;

    public function revokeRefTokenByUserId(int $userId): void;

    public function createAccessToken(int $id): ?string;

    public function createRefToken(int $id): ?string;

    public function createTokenResponse(string $accessToken, string $refreshToken): mixed;

    public function findValidRefreshToken(string $refreshToken): ?RefreshToken;

    public function getCurrentUser(): UserAccount;

    public function createPasswordResetToken(): string;

    public function savePasswordResetToken(array $data): void;

    public function findPasswordRsTokenByToken(string $token): ?PasswordResetToken;

    public function deletePasswordResetToken(string $email): void;

    public function logout(): void;
}
