<?php

namespace App\Entrypoint\Controller;

use App\Shared\Entrypoint\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class IndexController extends BaseController
{
    public function __invoke(Request $request, SessionInterface $session): JsonResponse
    {
        return $this->response("HOLA");
    }
}
