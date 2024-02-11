<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

class Auth0Base
{
    public Auth0 $auth0;

    public SdkConfiguration $configuration;

    public function __construct(
        string $auth0Domain,
        string $auth0ClientId,
        string $auth0ClientSecret,
        string $auth0Audience,
        string $auth0Cookie,
        string $auth0Callback,
    ) {
        $this->auth0 = new Auth0([
            'redirectUri' => $_ENV['LOGIN_REDIRECT_URI'],
            'domain' => $_ENV['AUTH0_DOMAIN'],
            'clientId' => $_ENV['AUTH0_CLIENT_ID'],
            'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
            'cookieSecret' => $_ENV['COOKIE_SECRET']
        ]);
    }
}
