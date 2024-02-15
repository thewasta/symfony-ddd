<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\User;

use App\Shared\Infrastructure\Security\Auth0Base;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserLogoutController
{
    public function __construct(private readonly Auth0Base $auth0) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->auth0->getAuth()->logout();
        return new JsonResponse(['message' => 'Successfully logged out']);
    }
}
