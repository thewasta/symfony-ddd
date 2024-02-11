<?php

namespace App\Entrypoint\Controller;

use App\Application\Query\BeerRetrieverQuery;
use App\Shared\Domain\Command\MessageAppBusInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

#[IsGranted('ROLE_USER')]
class BeerRetrieverController extends AbstractController
{
    public function __construct(private readonly MessageAppBusInterface $bus) {}

    public function __invoke(SessionInterface $session): JsonResponse
    {
        $response = $this->bus->handleCommand(new BeerRetrieverQuery());

        $response = $response->response();
        return new JsonResponse($response);
    }
}
