<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\User;

use App\Shared\Infrastructure\Security\Auth0Base;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserLogoutController extends Auth0Base
{
    public function __invoke(Request $request): JsonResponse
    {
        $this->auth0->logout();
        return new JsonResponse(['message' => 'Successfully logged out']);
    }
}
