<?php

namespace App\Application\Services;

use App\Domain\Entities\UserEntity;
use App\Models\UserAccount;

interface UserProfileServiceInterface
{
    public function getMyProfile(UserAccount $userAccount): mixed;

    public function getUserProfile(string $username): mixed;

    public function updateByUserAccountId(int $userAccountId, array $data): void;
}
