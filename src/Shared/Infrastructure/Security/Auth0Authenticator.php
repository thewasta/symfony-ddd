<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Security;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\ConfigurationException;
use Auth0\SDK\Exception\NetworkException;
use Auth0\SDK\Exception\StateException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class Auth0Authenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    private SdkConfiguration $configuration;

    private const AUTH0_CALLBACK_ROUTE = 'auth0_login_callback';

    private Auth0 $auth0;

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
        string $auth0ManagementToken,
        private readonly RouterInterface $router
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
        $this->auth0 = new Auth0($this->configuration);
    }

    public function supports(Request $request): ?bool
    {
        try {
            if ($request->attributes->get('_route') !== self::AUTH0_CALLBACK_ROUTE) {
                return false;
            }
            $this->auth0->getCredentials();
            return $request->attributes->get('_route') === self::AUTH0_CALLBACK_ROUTE;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @throws NetworkException
     * @throws StateException
     */
    public function authenticate(Request $request): Passport
    {
        $this->auth0->exchange();
        $userData = $this->auth0->getCredentials();
        return new SelfValidatingPassport(
            new UserBadge(json_encode($userData))
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->router->generate('app_login_success'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        throw new AccessDeniedHttpException($exception->getMessage(), $exception);
    }
}
