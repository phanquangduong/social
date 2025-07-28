<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\AuthUseCase;
use App\Helpers\ApiResponse;
use App\Helpers\DomainException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\UpdatePasswordRegisterRequest;
use App\Http\Requests\Auth\VerifyOtpRegisterRequest;

class AuthController
{
    public function __construct(private AuthUseCase $authUC) {}

    public function login(LoginRequest $request)
    {
        try {
            $data = $request->validated();
            $data['ip'] = $request->ip();
            $result = $this->authUC->login($data);
            return ApiResponse::success($result);
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authUC->register($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function verifyOtpRegister(VerifyOtpRegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->authUC->verifyOtpRegister($data);
            return ApiResponse::success($result);
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function updatePasswordRegister(UpdatePasswordRegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authUC->updatePasswordRegister($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function refreshToken(RefreshTokenRequest $request)
    {
        try {
            $data = $request->validated();
            $result = $this->authUC->refreshToken($data);
            return ApiResponse::success($result);
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authUC->forgotPassword($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authUC->resetPassword($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function logout()
    {
        try {
            $this->authUC->logout();
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }
}
