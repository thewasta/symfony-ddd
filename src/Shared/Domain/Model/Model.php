<?php

namespace App\Shared\Domain\Model;

use App\Shared\Domain\Events\DomainEvent;

abstract class Model
{
    private array $events;

    abstract public function toArray(): array;

    final public function events(): array
    {
        return $this->events;
    }

    final protected function publish(DomainEvent $event): void
    {
        $this->events[] = $event;
    }
}
