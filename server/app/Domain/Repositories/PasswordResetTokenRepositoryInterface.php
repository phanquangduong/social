<?php

namespace App\Domain\Repositories;

use App\Models\PasswordResetToken;

interface PasswordResetTokenRepositoryInterface
{
    public function store(array $data): void;

    public function findByToken(string $token): ?PasswordResetToken;

    public function delete(string $email): void;
}
