<?php

namespace App\Infrastructure\Services;

use App\Application\Services\AuthServiceInterface;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\Repositories\UserVerificationRepositoryInterface;
use App\Models\PasswordResetToken;
use App\Models\RefreshToken;
use App\Models\UserAccount;
use App\Models\UserVerification;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthService implements AuthServiceInterface
{
    public function __construct(
        private UserVerificationRepositoryInterface $userVerificationRepo,
        private RefreshTokenRepositoryInterface $refreshTokenRepo,
        private PasswordResetTokenRepositoryInterface $passwordResetTokenRepo
    ) {}

    public function getCurrentUser(): UserAccount
    {
        return Auth::user();
    }

    public function generateSixDigitOtp(): string
    {
        return (string) random_int(100000, 999999);
    }

    public function generateSha256Hash(string $key): string
    {
        return hash('sha256', $key);
    }

    public function hashPassword(string $value): string
    {
        return Hash::make($value);
    }

    public function checkPassword(string $plain, string $hashed): bool
    {
        return Hash::check($plain, $hashed);
    }

    public function revokeRefTokenByUserId(int $userId): void
    {
        $this->refreshTokenRepo->revokeByUserId($userId);
    }

    public function createAccessToken(int $id): ?string
    {
        $user = UserAccount::find($id);

        return Auth::login($user);
    }

    public function createRefToken(int $id): ?string
    {
        $expiresAt = new DateTime('+' . config('jwt.refresh_ttl') . ' minutes');

        $data = [
            'sub' => $id,
            'random' => rand() . time(),
            'exp' => $expiresAt->getTimestamp(),
        ];

        $refreshToken = JWTAuth::getJWTProvider()->encode($data);

        $this->refreshTokenRepo->store($id, $refreshToken, $expiresAt);

        return $refreshToken;
    }

    public function findValidRefreshToken(string $refreshToken): ?RefreshToken
    {
        return $this->refreshTokenRepo->findValidRefreshToken($refreshToken);
    }

    public function createPasswordResetToken(): string
    {
        $token = Str::random(64);

        return $token;
    }

    public function savePasswordResetToken(array $data): void
    {
        $this->passwordResetTokenRepo->store($data);
    }

    public function findPasswordRsTokenByToken(string $token): ?PasswordResetToken
    {
        return $this->passwordResetTokenRepo->findByToken($token);
    }

    public function deletePasswordResetToken(string $email): void
    {
        $this->passwordResetTokenRepo->delete($email);
    }


    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }


    public function createTokenResponse(string $accessToken, string $refreshToken): mixed
    {
        return  [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }
}
