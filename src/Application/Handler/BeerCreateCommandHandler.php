<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\BeerCreateCommand;
use App\Domain\Exception\BeerAlreadyExist;
use App\Domain\Service\BeerCreator;
use App\Shared\Application\Handler\AppCommandHandler;
use App\Shared\Domain\Command\MessageAppBusInterface;

class BeerCreateCommandHandler extends AppCommandHandler
{
    public function __construct(private readonly BeerCreator $creator, private readonly MessageAppBusInterface $bus) {}

    /**
     * @throws BeerAlreadyExist
     */
    public function __invoke(BeerCreateCommand $command): void
    {
        $beer = $this->creator->__invoke(
            $command->id(),
            $command->name(),
            $command->image(),
            $command->price()
        );

        foreach ($beer->events() as $event) {
            $this->bus->dispatch($event);
        }
    }
}
