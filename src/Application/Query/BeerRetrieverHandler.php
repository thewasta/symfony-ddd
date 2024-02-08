<?php

namespace App\Application\Query;

use App\Application\Service\Beer\BeerRetriever;
use App\Application\Transform\BeerRetrieverTransform;
use App\Shared\Domain\Command\MessageBusResponse;

class BeerRetrieverHandler
{
    public function __construct(
        private readonly BeerRetriever $retriever,
        private readonly BeerRetrieverTransform $transform
    ) {}

    public function __invoke(BeerRetrieverQuery $command): MessageBusResponse
    {
        $beers = $this->retriever->__invoke();

        return MessageBusResponse::create($this->transform->transform($beers));
    }
}