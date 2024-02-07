<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Command;

use App\Shared\Domain\Command\MessageAppBusInterface;
use App\Shared\Domain\Command\MessageBusResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class AppMessageAppBus implements MessageAppBusInterface
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $bus) {}

    public function dispatch($command): void
    {
        $this->bus->dispatch($command);
    }

    public function handleCommand($command): MessageBusResponse
    {
        return $this->handle($command);
    }
}
