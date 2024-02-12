<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\User;

use App\Shared\Infrastructure\Security\Auth0Base;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class UserLoginController extends AbstractController
{
    public function __construct(private readonly Auth0Base $auth0Base) {}

    public function __invoke(Request $request, SessionInterface $session): Response
    {
        return $this->redirect($this->auth0Base->auth0->login());
    }

    public function callback(Request $request, SessionInterface $session): void {}

    public function loginSuccess(): JsonResponse
    {
        return new JsonResponse(["success" => true]);
    }
}
