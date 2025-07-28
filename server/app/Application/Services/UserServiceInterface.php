<?php

namespace App\Application\Services;

use App\Domain\Entities\UserEntity;
use App\Models\UserAccount;

interface UserServiceInterface
{
    public function getUserAccountByAccount(string $account): ?UserAccount;

    public function getUserAccountById(int $id): ?UserAccount;

    public function addUserAccount(array $data): void;

    public function changePassword(UserAccount $userAccount, string $password): void;
}
