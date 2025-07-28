<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\UserEntity;
use App\Domain\Factories\UserEntityFactory;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\UserAccount;
use App\Models\UserVerification;

class UserRepository implements UserRepositoryInterface
{
    public function getUserAccountByAccount(string $account): ?UserAccount
    {
        return UserAccount::where('account', $account)->first();
    }

    public function getUserAccountById(int $id): ?UserAccount
    {
        return UserAccount::find($id);
    }

    public function addUserAccount(array $data): void
    {
        UserAccount::create([
            'account'  => $data['account'],
            'password' => $data['password'],
        ]);
    }

    public function changePassword(UserAccount $userAccount, string $password): void
    {
        $userAccount->password = $password;
        $userAccount->save();
    }
}
