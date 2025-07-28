<?php

namespace App\Application\Services;

interface MailServiceInterface
{
    public function sendOtpEmail(string $email, string $otp): void;

    public function sendResetPasswordEmail(string $email, string $token): void;
}
