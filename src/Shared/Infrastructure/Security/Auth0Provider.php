<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use App\Domain\Model\User\User;
use App\Shared\Domain\Model\ValueObject\DateTimeValueObject;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Management;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\ArgumentException;
use Auth0\SDK\Exception\ConfigurationException;
use Auth0\SDK\Exception\NetworkException;
use JsonException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class Auth0Provider implements UserProviderInterface
{
    private SdkConfiguration $configuration;

    /**
     * @throws ConfigurationException
     */
    public function __construct(
        string $auth0Domain,
        string $auth0ClientId,
        string $auth0ClientSecret,
        string $auth0Audience,
        string $auth0Cookie,
        string $auth0Callback,
        string $auth0ManagementToken
    ) {
        $this->configuration = new SdkConfiguration(
            domain: $auth0Domain,
            clientId: $auth0ClientId,
            redirectUri: $auth0Callback,
            clientSecret: $auth0ClientSecret,
            audience: [$auth0Audience],
            cookieSecret: $auth0Cookie,
            managementToken: $auth0ManagementToken
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException();
        }
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return User::class === $class;
    }

    /**
     * @throws ArgumentException
     * @throws NetworkException
     * @throws ConfigurationException
     * @throws JsonException
     */
    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        return $this->fetchUser($identifier);
    }

    /**
     * @throws ArgumentException
     * @throws NetworkException
     * @throws ConfigurationException
     * @throws JsonException
     * @throws \Exception
     */
    public function fetchUser(string $identifier): UserInterface
    {
        $userData = json_decode($identifier, true);

        $auth0Management = new Management($this->configuration);
//        https://auth0.com/docs/api/management/v2/users/patch-users-by-id
//        $auth0Management->users()->get($userData["user"]["sub"]);
        $userRolesResponse = $auth0Management->users()->getRoles($userData['user']['sub']);
        $userAuth0 = $auth0Management->users()->get($userData["user"]["sub"]);
        $userRoles = json_decode($userRolesResponse->getBody()->getContents(), false, 512, JSON_THROW_ON_ERROR);
        $parseUserAuth = json_decode($userAuth0->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
        return new User(
            userId: $userData['user']['sub'],
            userName: $userData['user']['nickname'],
            email: $userData['user']['email'],
            photo: $userData['user']["picture"],
            firstName: $userData['user']["name"],
            updatedAt: isset($userData['user']['updated_at']) ? DateTimeValueObject::from(
                $userData['user']['updated_at']
            ) : DateTimeValueObject::now(),
            lastLogin: DateTimeValueObject::from($parseUserAuth["last_login"]),
            emailVerified: $userData["user"]["email_verified"],
            lastName: $userData['user']["name"],
            accessToken: $userData["access_token"] ?? null,
            totalLogin: $parseUserAuth["logins_count"],
            roles: $this->roles($userRoles)
        );
    }

    public function roles(array $userRoles): array
    {
        $roles = [];
        foreach ($userRoles as $role) {
            $roles[] = $role->name;
        }
        $roles[] = "IS_AUTHENTICATED_FULLY";
        return $roles;
    }
}
