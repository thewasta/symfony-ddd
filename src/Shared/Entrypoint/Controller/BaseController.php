<?php

namespace App\Shared\Entrypoint\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public function response(string $message, array $response = null, int $code = 100): JsonResponse
    {
        $httpCodeStatus = $code < 300 ? 200 : 400;
        $messageResponse = [
            "code" => $code,
            $message => $message,
            "response" => $response
        ];
        return new JsonResponse(
            $messageResponse,
            $httpCodeStatus,
            [
                "Content-Type" => "application/json"
            ]
        );
    }
}
