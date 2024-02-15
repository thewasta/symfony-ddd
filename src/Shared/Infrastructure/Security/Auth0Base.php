<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use Auth0\SDK\API\Management;
use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\ConfigurationException;

class Auth0Base implements Auth0Interface
{
    public Auth0 $auth0;

    private SdkConfiguration $configuration;

    /**
     * @throws ConfigurationException
     */
    public function __construct(
        private readonly string $auth0Domain,
        private readonly string $auth0ClientId,
        private readonly string $auth0ClientSecret,
        private readonly string $auth0Cookie,
        private readonly string $auth0Callback,
        private readonly string $auth0ManagementToken
    ) {
        $this->configuration = new SdkConfiguration(
            domain: $this->auth0Domain,
            clientId: $this->auth0ClientId,
            redirectUri: $this->auth0Callback,
            clientSecret: $this->auth0ClientSecret,
            cookieSecret: $this->auth0Cookie,
            managementToken: $this->auth0ManagementToken
        );
    }

    public function getAuth(): Auth0
    {
        $this->auth0 = new Auth0($this->configuration);
        return $this->auth0;
    }

    /**
     * @throws ConfigurationException
     */
    public function getManagement(): Management
    {
        return new Management($this->configuration);
    }
}
