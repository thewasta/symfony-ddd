<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\MessageBus\Command;

use App\Shared\Domain\Command\MessageAppBusInterface;
use App\Shared\Domain\Command\MessageBusResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageAppBus implements MessageAppBusInterface
{
    use HandleTrait;

    public function __construct(private readonly MessageBusInterface $bus)
    {
        $this->messageBus = $bus;
    }

    public function dispatch($command): void
    {
        $this->bus->dispatch($command);
    }

    public function handleCommand($command): MessageBusResponse
    {
        return $this->handle($command);
    }
}
