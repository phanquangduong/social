<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Models\PasswordResetToken;
use Carbon\Carbon;

class PasswordResetTokenRepository implements PasswordResetTokenRepositoryInterface
{
    public function store(array $data): void
    {
        PasswordResetToken::updateOrInsert(
            ['email' => $data['email']],
            [
                'token' => $data['token'],
                'created_at' => Carbon::now(),
            ]
        );
    }

    public function findByToken(string $token): ?PasswordResetToken
    {
        return PasswordResetToken::where('token', $token)->first();
    }

    public function delete(string $email): void
    {
        PasswordResetToken::where('email', $email)->delete();
    }
}
