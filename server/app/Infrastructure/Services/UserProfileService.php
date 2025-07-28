<?php

namespace App\Infrastructure\Services;

use App\Application\Services\UserProfileServiceInterface;
use App\Domain\Repositories\UserProfileRepositoryInterface;
use App\Models\UserAccount;

class UserProfileService implements UserProfileServiceInterface
{
    public function __construct(private UserProfileRepositoryInterface $userProfileRepo) {}

    public function getMyProfile(UserAccount $userAccount): mixed
    {
        return $this->userProfileRepo->getMyProfile($userAccount);
    }

    public function getUserProfile(string $username): mixed
    {
        return $this->userProfileRepo->getUserProfile($username);
    }

    public function updateByUserAccountId(int $userAccountId, array $data): void
    {
        $this->userProfileRepo->updateByUserAccountId($userAccountId, $data);
    }
}
