<?php

namespace App\Providers;

use App\Application\Services\AuthServiceInterface;
use App\Application\Services\CacheServiceInterface;
use App\Application\Services\FileUploadServiceInterface;
use App\Application\Services\FriendServiceInterface;
use App\Application\Services\MailServiceInterface;
use App\Application\Services\UserProfileServiceInterface;
use App\Application\Services\UserServiceInterface;
use App\Application\Services\UserVerificationServiceInterface;
use App\Domain\Repositories\FriendRepositoryInterface;
use App\Domain\Repositories\PasswordResetTokenRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\Repositories\UserProfileRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\UserVerificationRepositoryInterface;
use App\Infrastructure\Repositories\FriendRepository;
use App\Infrastructure\Repositories\PasswordResetTokenRepository;
use App\Infrastructure\Repositories\RefreshTokenRepository;
use App\Infrastructure\Repositories\UserProfileRepository;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Repositories\UserVerificationRepository;
use App\Infrastructure\Services\AuthService;
use App\Infrastructure\Services\CacheService;
use App\Infrastructure\Services\CloudinaryFileUploadService;
use App\Infrastructure\Services\FriendService;
use App\Infrastructure\Services\MailService;
use App\Infrastructure\Services\UserProfileService;
use App\Infrastructure\Services\UserService;
use App\Infrastructure\Services\UserVerificationService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Services
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(MailServiceInterface::class, MailService::class);
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserVerificationServiceInterface::class, UserVerificationService::class);
        $this->app->bind(UserProfileServiceInterface::class, UserProfileService::class);
        $this->app->bind(FileUploadServiceInterface::class, CloudinaryFileUploadService::class);
        $this->app->bind(FriendServiceInterface::class, FriendService::class);

        // Repositories
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserVerificationRepositoryInterface::class, UserVerificationRepository::class);
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
        $this->app->bind(RefreshTokenRepositoryInterface::class, RefreshTokenRepository::class);
        $this->app->bind(PasswordResetTokenRepositoryInterface::class, PasswordResetTokenRepository::class);
        $this->app->bind(FriendRepositoryInterface::class, FriendRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
    }
}
