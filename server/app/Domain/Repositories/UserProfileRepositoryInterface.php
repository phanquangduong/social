<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;
use App\Models\UserAccount;

interface UserProfileRepositoryInterface
{
    public function getMyProfile(UserAccount $userAccount): mixed;

    public function getUserProfile(string $username): mixed;

    public function updateByUserAccountId(int $userAccountId, array $data): void;
}
