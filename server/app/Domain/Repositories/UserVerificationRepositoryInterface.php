<?php

namespace App\Domain\Repositories;

use App\Models\UserVerification;

interface UserVerificationRepositoryInterface
{
    public function createOrUpdate(string $verifyKey, string $hashKey, string $otp): void;

    public function findByKey(string $verifyKey): ?UserVerification;

    public function findByHashKey(string $hashKey): ?UserVerification;

    public function updateStatus(string $verifyKey): void;
}
