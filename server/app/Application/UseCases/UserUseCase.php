<?php

namespace App\Application\UseCases;

use App\Application\Services\AuthServiceInterface;
use App\Application\Services\FileUploadServiceInterface;
use App\Application\Services\UserProfileServiceInterface;
use App\Application\Services\UserServiceInterface;
use App\Helpers\DomainException;
use Illuminate\Http\UploadedFile;

class UserUseCase
{
    protected array $errors;
    protected array $success;

    public function __construct(
        private AuthServiceInterface $authService,
        private UserServiceInterface $userService,
        private UserProfileServiceInterface $userProfileService,
        private FileUploadServiceInterface $fileUploadService
    ) {
        $this->errors = config('response_messages.errors');
        $this->success = config('response_messages.success');
    }

    public function getMyProfile(): mixed
    {
        $userAccount = $this->authService->getCurrentUser();
        return $this->userProfileService->getMyProfile($userAccount);
    }

    public function getUserProfile(string $username): mixed
    {
        $userAccount = $this->userProfileService->getUserProfile($username);

        if (!$userAccount) {
            throw new DomainException(
                $this->errors['USER_NOT_FOUND']['message'],
                $this->errors['USER_NOT_FOUND']['status'],
                $this->errors['USER_NOT_FOUND']['code'],
            );
        }

        return $userAccount;
    }

    public function updateProfile(array $data): void
    {
        $avatarFolder = config('const_params.upload_file_folders.avatar');
        $coverFolder = config('const_params.upload_file_folders.cover_image');

        $userAccount = $this->authService->getCurrentUser();
        $currentProfile = $userAccount->profile;
        $data['user_account_id'] = $userAccount['id'];
        $data['email'] = $userAccount['account'];

        if (!empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {

            if (!empty($currentProfile['avatar'])) {
                $this->fileUploadService->delete($currentProfile['avatar']);
            }

            $data['avatar'] = $this->fileUploadService->upload($data['avatar'], $avatarFolder);
        }

        if (!empty($data['cover_image']) && $data['cover_image'] instanceof UploadedFile) {

            if (!empty($currentProfile['cover_image'])) {
                $this->fileUploadService->delete($currentProfile['cover_image']);
            }
            $data['cover_image'] = $this->fileUploadService->upload($data['cover_image'], $coverFolder);
        }

        $this->userProfileService->updateByUserAccountId($userAccount->id, $data);
    }

    public function changePassword(array $data): void
    {
        $oldPassword = $data['old_password'];
        $newPassword = $data['new_password'];

        $userAccount = $this->authService->getCurrentUser();

        if (!$this->authService->checkPassword($oldPassword, $userAccount->password)) {
            throw new DomainException(
                $this->errors['INCORRECT_PASSWORD']['message'],
                $this->errors['INCORRECT_PASSWORD']['status'],
                $this->errors['INCORRECT_PASSWORD']['code'],
            );
        }

        $hashedPassword = $this->authService->hashPassword($newPassword);
        $this->userService->changePassword($userAccount, $hashedPassword);
    }
}
