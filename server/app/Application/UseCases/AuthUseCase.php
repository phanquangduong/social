<?php

namespace App\Application\UseCases;

use App\Application\Services\AuthServiceInterface;
use App\Application\Services\CacheServiceInterface;
use App\Application\Services\MailServiceInterface;
use App\Application\Services\UserServiceInterface;
use App\Application\Services\UserVerificationServiceInterface;
use App\Events\UserLoggedInEvent;
use App\Events\UserLoggedOutEvent;
use App\Helpers\DomainException;


class AuthUseCase
{
    protected array $errors;
    protected array $success;

    public function __construct(
        private CacheServiceInterface $cacheService,
        private AuthServiceInterface $authService,
        private MailServiceInterface $mailService,
        private UserServiceInterface $userService,
        private UserVerificationServiceInterface $userVerificationService
    ) {
        $this->errors = config('response_messages.errors');
        $this->success = config('response_messages.success');
    }

    public function login(array $data): mixed
    {
        $account = $data['account'];
        $password = $data['password'];
        $ip = $data['ip'];

        $accFound = $this->userService->getUserAccountByAccount($account);

        if (!$accFound || !$this->authService->checkPassword($password, $accFound->password)) {
            throw new DomainException(
                $this->errors['LOGIN_FAILED']['message'],
                $this->errors['LOGIN_FAILED']['status'],
                $this->errors['LOGIN_FAILED']['code'],

            );
        }

        $this->authService->revokeRefTokenByUserId($accFound->id);
        $accToken = $this->authService->createAccessToken($accFound->id);
        $refToken = $this->authService->createRefToken($accFound->id);

        event(new UserLoggedInEvent($accFound->id, $ip));

        return $this->authService->createTokenResponse($accToken, $refToken);
    }

    public function register(array $data): void
    {

        $verifyKey = $data['verify_key'];
        $hashKey = $this->authService->generateSha256Hash($verifyKey);

        $userAccount = $this->userService->getUserAccountByAccount($verifyKey);

        if ($userAccount) {
            throw new DomainException(
                $this->errors['USER_ALREADY_EXISTS']['message'],
                $this->errors['USER_ALREADY_EXISTS']['status'],
                $this->errors['USER_ALREADY_EXISTS']['code']
            );
        }

        $userKey = $this->cacheService->makeOtpKey($hashKey);

        if ($this->cacheService->has($userKey)) {
            throw new DomainException(
                $this->errors['OTP_ALREADY_SENT']['message'],
                $this->errors['OTP_ALREADY_SENT']['status'],
                $this->errors['OTP_ALREADY_SENT']['code'],
            );
        }

        $otpNew = $this->authService->generateSixDigitOtp();

        $otpNew = '123456';

        $this->cacheService->put($userKey, $otpNew);
        $this->userVerificationService->storeOrUpdateOtpToDatabase($verifyKey, $hashKey, $otpNew);

        // Send mail
        $this->mailService->sendOtpEmail($verifyKey, $otpNew);
    }

    public function verifyOtpRegister(array $data): mixed
    {
        $verifyKey = $data['verify_key'];
        $otp = $data['otp'];
        $hashKey = $this->authService->generateSha256Hash($verifyKey);
        $userKey = $this->cacheService->makeOtpKey($hashKey);

        $otpFound = $this->cacheService->get($userKey);
        if ($otpFound === null) {
            throw new DomainException(
                $this->errors['OTP_NOT_EXISTS']['message'],
                $this->errors['OTP_NOT_EXISTS']['status'],
                $this->errors['OTP_NOT_EXISTS']['code'],
            );
        }

        if ($otp != $otpFound) {
            throw new DomainException(
                $this->errors['INVALID_OTP']['message'],
                $this->errors['INVALID_OTP']['status'],
                $this->errors['INVALID_OTP']['code'],
            );
        }

        $this->userVerificationService->updateUserVerificationStatus($verifyKey);

        return [
            'token' => $hashKey
        ];
    }

    public function updatePasswordRegister(array $data): void
    {
        $token = $data['token'];
        $password = $data['password'];

        $infoOtp = $this->userVerificationService->findVerificationByHashKey($token);

        if (!$infoOtp) {
            throw new DomainException(
                $this->errors['USER_OTP_NOT_EXISTS']['message'],
                $this->errors['USER_OTP_NOT_EXISTS']['status'],
                $this->errors['USER_OTP_NOT_EXISTS']['code'],
            );
        }

        if (!$infoOtp->is_verified) {
            throw new DomainException(
                $this->errors['OTP_NOT_VERIFIED']['message'],
                $this->errors['OTP_NOT_VERIFIED']['status'],
                $this->errors['OTP_NOT_VERIFIED']['code'],
            );
        }

        $userAccount = $this->userService->getUserAccountByAccount($infoOtp->key);
        if ($userAccount) {
            throw new DomainException(
                $this->errors['USER_ALREADY_EXISTS']['message'],
                $this->errors['USER_ALREADY_EXISTS']['status'],
                $this->errors['USER_ALREADY_EXISTS']['code'],
            );
        }

        $hashedPassword = $this->authService->hashPassword($password);

        $this->userService->addUserAccount([
            'account' => $infoOtp->key,
            'password' => $hashedPassword,
        ]);
    }

    public function refreshToken(array $data): mixed
    {
        $refToken = $data['refresh_token'];

        $refTokenFound = $this->authService->findValidRefreshToken($refToken);

        if (!$refTokenFound) {
            throw new DomainException(
                $this->errors['INVALID_TOKEN']['message'],
                $this->errors['INVALID_TOKEN']['status'],
                $this->errors['INVALID_TOKEN']['code'],
            );
        }

        $this->authService->revokeRefTokenByUserId($refTokenFound->user_account_id);
        $accToken = $this->authService->createAccessToken($refTokenFound->user_account_id);
        $refToken = $this->authService->createRefToken($refTokenFound->user_account_id);

        return $this->authService->createTokenResponse($accToken, $refToken);
    }

    public function forgotPassword(array $data): void
    {
        $email = $data['email'];

        $userAccount = $this->userService->getUserAccountByAccount($email);

        if (!$userAccount) {
            throw new DomainException(
                $this->errors['USER_NOT_FOUND']['message'],
                $this->errors['USER_NOT_FOUND']['status'],
                $this->errors['USER_NOT_FOUND']['code'],
            );
        }

        $token = $this->authService->createPasswordResetToken();

        $data = [
            'email' => $email,
            'token' => $token
        ];

        $this->authService->savePasswordResetToken($data);

        // Send mail
        $this->mailService->sendResetPasswordEmail($email, $token);
    }

    public function resetPassword(array $data): void
    {
        $token = $data['token'];
        $password = $data['password'];

        $tokenFound = $this->authService->findPasswordRsTokenByToken($token);

        if (!$tokenFound) {
            throw new DomainException(
                $this->errors['INVALID_TOKEN']['message'],
                $this->errors['INVALID_TOKEN']['status'],
                $this->errors['INVALID_TOKEN']['code'],
            );
        }

        $userAccount = $this->userService->getUserAccountByAccount($tokenFound->email);

        if (!$userAccount) {
            throw new DomainException(
                $this->errors['USER_NOT_FOUND']['message'],
                $this->errors['USER_NOT_FOUND']['status'],
                $this->errors['USER_NOT_FOUND']['code'],
            );
        }

        $hashedPassword = $this->authService->hashPassword($password);
        $this->userService->changePassword($userAccount, $hashedPassword);
        $this->authService->deletePasswordResetToken($tokenFound->email);
    }

    public function logout(): void
    {
        $userAccount = $this->authService->getCurrentUser();
        event(new UserLoggedOutEvent($userAccount->id));

        $this->authService->revokeRefTokenByUserId($userAccount->id);
        $this->authService->logout();
    }
}
