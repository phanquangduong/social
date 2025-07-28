<?php

namespace App\Application\Services;

use App\Models\UserVerification;

interface UserVerificationServiceInterface
{
    public function storeOrUpdateOtpToDatabase(string $key, string $hashKey, string $otp): void;

    public function findVerificationByKey(string $verifyKey): ?UserVerification;

    public function findVerificationByHashKey(string $hashKey): ?UserVerification;

    public function updateUserVerificationStatus(string $verifyKey): void;
}
