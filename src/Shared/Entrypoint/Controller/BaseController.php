<?php

namespace App\Shared\Entrypoint\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

abstract class BaseController extends AbstractController
{
    public function response(
        string $message,
        int $httpCode = 200,
        array $response = null,
        int $code = 100
    ): JsonResponse {
        $messageResponse = [
            "code" => $code,
            $message => $message,
            "response" => $response
        ];
        return new JsonResponse(
            $messageResponse,
            $httpCode,
            [
                "Content-Type" => "application/json"
            ]
        );
    }
}
