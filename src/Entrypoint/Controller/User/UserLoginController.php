<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller\User;

use App\Shared\Infrastructure\Security\Auth0Base;
use Auth0\SDK\Exception\ConfigurationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserLoginController extends AbstractController
{
    public function __construct(private readonly Auth0Base $auth0) {}

    /**
     * @throws ConfigurationException
     */
    public function __invoke(Request $request, SessionInterface $session): Response
    {
        return $this->redirect($this->auth0->getAuth()->login());
    }

    public function callback(): Response
    {
        return $this->redirectToRoute('index');
    }

    public function success(): Response
    {
        if (!$this->container->get('security.token_storage')->getToken()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('success_login.html.twig');
    }
}
