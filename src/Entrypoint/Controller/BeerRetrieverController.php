<?php

namespace App\Entrypoint\Controller;

use App\Application\Query\BeerRetrieverQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class BeerRetrieverController extends AbstractController
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $bus) {}

    public function __invoke(): JsonResponse
    {
        $envelope = $this->bus->dispatch(new BeerRetrieverQuery());
        $handleStamp = $envelope->last(HandledStamp::class);

        $response = $handleStamp->getResult();
        return new JsonResponse($response);
    }
}
