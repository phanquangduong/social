<?php

namespace App\Application\Services;

interface CacheServiceInterface
{
    public function has(string $key): bool;

    public function put(string $key, mixed $value, int $ttl = 300): void;

    public function get(string $key): mixed;

    public function forget(string $key): void;

    public function makeOtpKey(string $baseKey): string;
}
