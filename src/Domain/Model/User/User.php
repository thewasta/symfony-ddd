<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use App\Domain\Events\User\UserCreated;
use App\Domain\Model\User\ValueObject\UserAccessToken;
use App\Domain\Model\User\ValueObject\UserAuth0Id;
use App\Domain\Model\User\ValueObject\UserEmail;
use App\Domain\Model\User\ValueObject\UserEmailVerified;
use App\Domain\Model\User\ValueObject\UserExpiredAccessToken;
use App\Domain\Model\User\ValueObject\UserFirstName;
use App\Domain\Model\User\ValueObject\UserLastLogin;
use App\Domain\Model\User\ValueObject\UserLastName;
use App\Domain\Model\User\ValueObject\UserLoginCount;
use App\Domain\Model\User\ValueObject\UserNickName;
use App\Domain\Model\User\ValueObject\UserPhoto;
use App\Domain\Model\User\ValueObject\UserUpdatedAt;
use App\Shared\Domain\Model\Model;
use Symfony\Component\Security\Core\User\UserInterface;

final class User extends Model implements UserInterface
{
    private function __construct(
        private readonly UserAuth0Id $userId,
        private readonly UserNickName $userName,
        private readonly UserEmail $email,
        private readonly UserPhoto $photo,
        private readonly UserFirstName $firstName,
        private readonly ?UserUpdatedAt $updatedAt,
        private readonly ?UserLastLogin $lastLogin,
        private readonly ?UserEmailVerified $emailVerified,
        private readonly UserLoginCount $totalLogin,
        private readonly ?UserLastName $lastName = null,
        private readonly ?UserAccessToken $accessToken = null,
        private readonly ?UserExpiredAccessToken $accessTokenExpired = null,
        private readonly ?array $roles = [],
    ) {}

    public static function create(
        UserAuth0Id $userId,
        UserNickName $userName,
        UserEmail $email,
        UserPhoto $photo,
        UserFirstName $firstName,
        ?UserUpdatedAt $updatedAt,
        UserLastLogin $lastLogin,
        UserEmailVerified $emailVerified,
        UserLoginCount $totalLogin,
        ?UserLastName $lastName = null,
        ?UserAccessToken $accessToken = null,
        ?UserExpiredAccessToken $accessTokenExpired = null,
        ?array $roles = [],
    ): self {
        $user = new self(
            $userId,
            $userName,
            $email,
            $photo,
            $firstName,
            $updatedAt,
            $lastLogin,
            $emailVerified,
            $totalLogin,
            $lastName,
            $accessToken,
            $accessTokenExpired,
            $roles
        );
        $user->publish(new UserCreated());
        return $user;
    }

    public function userId(): UserAuth0Id
    {
        return $this->userId;
    }

    public function userName(): UserNickName
    {
        return $this->userName;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function updatedAt(): UserUpdatedAt
    {
        return $this->updatedAt;
    }

    public function accessToken(): ?UserAccessToken
    {
        return $this->accessToken;
    }

    public function accessTokenExpired(): ?UserExpiredAccessToken
    {
        return $this->accessTokenExpired;
    }

    public function photo(): UserPhoto
    {
        return $this->photo;
    }

    public function firstName(): UserFirstName
    {
        return $this->firstName;
    }

    public function lastLogin(): UserLastLogin
    {
        return $this->lastLogin;
    }

    public function emailVerified(): UserEmailVerified
    {
        return $this->emailVerified;
    }

    public function lastName(): ?UserLastName
    {
        return $this->lastName;
    }

    public function totalLogin(): UserLoginCount
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
        return $this->userId()->value();
    }

    public function toArray(): array
    {
        return [
            "userId" => $this->userId()->value(),
            "userName" => $this->userName()->value(),
            "email" => $this->email()->value(),
            "photo" => $this->photo()->value(),
            "firstName" => $this->firstName()->value(),
            "updatedAt" => $this->updatedAt()->value(),
        ];
    }
}
