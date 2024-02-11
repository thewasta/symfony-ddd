<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    public function __construct(
        private string $userId,
        private ?string $userName,
        private ?string $email,
        private ?DateTimeImmutable $updatedAt,
        private ?array $roles = [],
        private ?string $accessToken = null,
        private ?bool $accessTokenExpired = null,
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
