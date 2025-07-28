<?php

namespace App\Domain\Entities;

class UserEntity
{
    public function __construct(
        private int $id,
        private string $account,
        private ?string $name,
        private ?string $username,
        private ?string $avatar,
        private ?string $cover_image,
        private ?string $email,
        private ?string $mobile,
        private ?int $state,
        private ?int $gender,
        private ?string $birthday,
        private ?string $login_time,
        private ?string $logout_time,
        private ?string $login_ip,
        private ?bool $is_verified,
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
    public function getAccount(): string
    {
        return $this->account;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    public function getCoverImage(): ?string
    {
        return $this->cover_image;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getMobile(): ?string
    {
        return $this->mobile;
    }
    public function getState(): ?int
    {
        return $this->state;
    }
    public function getGender(): ?int
    {
        return $this->gender;
    }
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }
    public function getLoginTime(): ?string
    {
        return $this->login_time;
    }
    public function getLogoutTime(): ?string
    {
        return $this->logout_time;
    }
    public function getLoginIp(): ?string
    {
        return $this->login_ip;
    }
    public function isVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'account' => $this->account,
            'name' => $this->name,
            'username' => $this->username,
            'avatar' => $this->avatar,
            'cover_image' => $this->cover_image,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'state' => $this->state,
            'gender' => $this->gender,
            'birthday' => $this->birthday,
            'login_time' => $this->login_time,
            'logout_time' => $this->logout_time,
            'login_ip' => $this->login_ip,
            'is_verified' => $this->is_verified,
        ];
    }
}
