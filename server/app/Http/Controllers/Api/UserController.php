<?php

namespace App\Http\Controllers\Api;

use App\Application\UseCases\UserUseCase;
use App\Helpers\ApiResponse;
use App\Helpers\DomainException;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;

class UserController
{

    public function __construct(private UserUseCase $userUC) {}

    public function getMyProfile()
    {
        try {
            $result = $this->userUC->getMyProfile();
            return ApiResponse::success($result);
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function getUserProfile(string $username)
    {
        try {
            $result = $this->userUC->getUserProfile($username);
            return ApiResponse::success($result);
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userUC->updateProfile($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->userUC->changePassword($data);
            return ApiResponse::success();
        } catch (DomainException $e) {
            return ApiResponse::fail($e->getMessage(), $e->getHttpStatus(), $e->getErrorCode(), $e->getErrors());
        }
    }
}
