<?php

namespace App\Infrastructure\Services;

use App\Application\Services\UserVerificationServiceInterface;
use App\Domain\Repositories\UserVerificationRepositoryInterface;
use App\Models\UserVerification;

class UserVerificationService implements UserVerificationServiceInterface
{
    public function __construct(private UserVerificationRepositoryInterface $userVerificationRepo) {}

    public function findVerificationByKey(string $verifyKey): ?UserVerification
    {
        return $this->userVerificationRepo->findByKey($verifyKey);
    }

    public function findVerificationByHashKey(string $hashKey): ?UserVerification
    {
        return $this->userVerificationRepo->findByHashKey($hashKey);
    }

    public function storeOrUpdateOtpToDatabase(string $key, string $hashKey, string $otp): void
    {
        $this->userVerificationRepo->createOrUpdate($key, $hashKey, $otp);
    }

    public function updateUserVerificationStatus(string $verifyKey): void
    {
        $this->userVerificationRepo->updateStatus($verifyKey);
    }
}
