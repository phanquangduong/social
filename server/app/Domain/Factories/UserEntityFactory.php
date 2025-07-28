<?php

namespace App\Domain\Factories;

use App\Domain\Entities\UserEntity;
use App\Models\UserAccount;
use App\Models\UserProfile;
use App\Models\UserVerification;

class UserEntityFactory
{
    public static function fromModels(
        UserAccount $account,
        UserProfile $profile,
        ?UserVerification $verification,
        array $hiddenFields = []
    ): array {
        $user = new UserEntity(
            id: $profile->user_account_id,
            account: $account->account,
            name: $profile->name,
            username: $profile->username,
            avatar: $profile->avatar,
            cover_image: $profile->cover_image,
            email: $profile->email,
            mobile: $profile->mobile,
            state: $profile->state,
            gender: $profile->gender,
            birthday: optional($profile->birthday)?->toDateString(),
            login_time: optional($account->login_time)?->toDateTimeString(),
            logout_time: optional($account->logout_time)?->toDateTimeString(),
            login_ip: $account->login_ip,
            is_verified: $verification?->is_verified ?? null,
        );

        $data = $user->toArray();

        foreach ($hiddenFields as $field) {
            unset($data[$field]);
        }

        return $data;
    }
}
