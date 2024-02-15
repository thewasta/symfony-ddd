<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public function __construct(
        private string $userId,
        private string $userName,
        private string $email,
        private string $photo,
        private string $firstName,
        private ?DateTimeImmutable $updatedAt,
        private ?DateTimeImmutable $lastLogin,
        private ?bool $emailVerified = false,
        private ?string $lastName = null,
        private ?string $accessToken = null,
        private ?bool $accessTokenExpired = null,
        private int $totalLogin = 0,
        private ?array $roles = [],
    ) {}

    public function userId(): string
    {
        return $this->userId;
    }

    public function userName(): ?string
    {
        return $this->userName;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function updatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setAccessToken(?string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function setAccessTokenExpired(?bool $accessTokenExpired): void
    {
        $this->accessTokenExpired = $accessTokenExpired;
    }

    public function accessToken(): ?string
    {
        return $this->accessToken;
    }

    public function accessTokenExpired(): ?bool
    {
        return $this->accessTokenExpired;
    }

    public function photo(): string
    {
        return $this->photo;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastLogin(): ?DateTimeImmutable
    {
        return $this->lastLogin;
    }

    public function emailVerified(): ?bool
    {
        return $this->emailVerified;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }

    public function totalLogin(): int
    {
        return $this->totalLogin;
    }

    public function getRoles(): array
    {
        if (empty($this->roles)) {
            return ['ROLE_USER'];
        }
        return $this->roles;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->userId;
    }
}
