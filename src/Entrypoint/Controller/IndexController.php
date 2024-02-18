<?php

namespace App\Entrypoint\Controller;

use App\Shared\Entrypoint\Controller\BaseController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Contracts\Cache\CacheInterface;

class IndexController extends BaseController
{

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(Request $request, SessionInterface $session, CacheInterface $cache): Response
    {
        if (!$this->container->get('security.token_storage')->getToken()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->redirectToRoute('app_login_success');
    }
}
