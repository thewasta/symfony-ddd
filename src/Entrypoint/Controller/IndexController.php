<?php

namespace App\Entrypoint\Controller;

use App\Shared\Entrypoint\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends BaseController
{
    public function __invoke(Request $request): JsonResponse
    {
        return $this->response("HOLA");
    }
}
