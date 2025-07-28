<?php

namespace App\Infrastructure\Services;

use App\Application\Services\MailServiceInterface;

class MailService implements MailServiceInterface
{
    public function sendOtpEmail(string $email, string $otp): void {}

    public function sendResetPasswordEmail(string $email, string $token): void {}
}
