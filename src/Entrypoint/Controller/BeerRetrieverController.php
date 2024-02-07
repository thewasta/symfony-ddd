<?php

namespace App\Entrypoint\Controller;

use App\Application\Query\BeerRetrieverQuery;
use App\Shared\Domain\Command\MessageAppBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;

class BeerRetrieverController extends AbstractController
{
    use HandleTrait;

    public function __construct(private readonly MessageAppBusInterface $bus) {}

    public function __invoke(): JsonResponse
    {
        $response = $this->bus->handleCommand(new BeerRetrieverQuery());

        $response = $response->response();
        return new JsonResponse($response);
    }
}
