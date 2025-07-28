<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\UserVerificationRepositoryInterface;
use App\Models\UserVerification;

class UserVerificationRepository implements UserVerificationRepositoryInterface
{
    public function createOrUpdate(string $verifyKey, string $hashKey, string $otp): void
    {
        UserVerification::updateOrCreate(
            ['key' => $verifyKey],
            [
                'otp' => $otp,
                'key_hash' => $hashKey,
                'is_verified' => false,
                'is_deleted' => false,
            ]
        );
    }

    public function findByKey(string $verifyKey): ?UserVerification
    {
        return UserVerification::where('key', $verifyKey)
            ->where('is_deleted', false)
            ->first();
    }

    public function findByHashKey(string $hashKey): ?UserVerification
    {
        return UserVerification::where('key_hash', $hashKey)
            ->where('is_deleted', false)
            ->first();
    }

    public function updateStatus(string $verifyKey): void
    {
        UserVerification::where('key', $verifyKey)
            ->where('is_deleted', false)
            ->update(['is_verified' => true]);
    }
}
