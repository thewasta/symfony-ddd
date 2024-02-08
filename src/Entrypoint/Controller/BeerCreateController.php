<?php

declare(strict_types=1);

namespace App\Entrypoint\Controller;

use App\Application\Query\BeerCreateCommand;
use App\Shared\Domain\Command\MessageAppBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BeerCreateController extends AbstractController
{
    public function __construct(private readonly MessageAppBusInterface $bus) {}

    public function __invoke(): JsonResponse
    {
        $this->bus->dispatch(new BeerCreateCommand());
        return new JsonResponse(["msg" => "Successfully created"], 201);
    }
}
