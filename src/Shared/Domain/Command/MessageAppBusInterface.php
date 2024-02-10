<?php

namespace App\Shared\Domain\Command;

interface MessageAppBusInterface
{
    public function dispatch($command): void;

    public function handleCommand($command): MessageBusResponse;
}
