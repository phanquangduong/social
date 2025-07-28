<?php

namespace App\Infrastructure\Services;

use App\Application\Services\UserServiceInterface;
use App\Domain\Entities\UserEntity;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\UserAccount;

class UserService implements UserServiceInterface
{
    public function __construct(private UserRepositoryInterface $userRepo) {}

    public function getUserAccountByAccount(string $account): ?UserAccount
    {
        return $this->userRepo->getUserAccountByAccount($account);
    }

    public function getUserAccountById(int $id): ?UserAccount
    {
        return $this->userRepo->getUserAccountById($id);
    }

    public function addUserAccount(array $data): void
    {
        $this->userRepo->addUserAccount($data);
    }

    public function changePassword(UserAccount $userAccount, string $password): void
    {
        $this->userRepo->changePassword($userAccount, $password);
    }
}
