<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\UserEntity;
use App\Domain\Factories\UserEntityFactory;
use App\Domain\Repositories\UserProfileRepositoryInterface;
use App\Models\UserAccount;
use App\Models\UserProfile;
use App\Models\UserVerification;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function getMyProfile(UserAccount $userAccount): mixed
    {
        $profile = $userAccount->profile;
        $verification = UserVerification::where('key', $userAccount->account)->first();
        return $profile
            ? UserEntityFactory::fromModels($userAccount, $profile, $verification)
            : null;
    }

    public function getUserProfile(string $username): mixed
    {
        $profile = UserProfile::where('username', $username)->first();
        if (!$profile) return null;
        $userAccount = $profile->userAccount;

        return UserEntityFactory::fromModels(
            $userAccount,
            $profile,
            null,
            ['account', 'login_ip', 'is_verified']
        );
    }

    public function updateByUserAccountId(int $userAccountId, array $data): void
    {
        UserProfile::updateOrCreate(
            ['user_account_id' => $userAccountId],
            $data
        );
    }
}
