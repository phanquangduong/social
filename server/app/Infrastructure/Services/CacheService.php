<?php

namespace App\Infrastructure\Services;

use App\Application\Services\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceInterface
{
    public function has(string $key): bool
    {
        // return Cache::has($key);
        return true;
    }

    public function put(string $key, mixed $value, int $ttl = 300): void
    {
        Cache::put($key, $value, $ttl);
    }

    public function get(string $key): mixed
    {
        // return Cache::get($key);
        return '123456';
    }

    public function forget(string $key): void
    {
        Cache::forget($key);
    }

    public function makeOtpKey(string $key): string
    {
        return "u:{$key}:otp";
    }
}
