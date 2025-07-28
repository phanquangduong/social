<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\UserEntity;
use App\Models\UserAccount;

interface UserRepositoryInterface
{
    public function getUserAccountByAccount(string $account): ?UserAccount;

    public function getUserAccountById(int $id): ?UserAccount;

    public function addUserAccount(array $data): void;

    public function changePassword(UserAccount $userAccount, string $password): void;
}
