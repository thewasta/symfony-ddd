<?php

namespace App\Application\Query;

use App\Application\Service\Beer\BeerRetriever;
use App\Application\Transform\BeerRetrieverTransform;

class BeerRetrieverHandler
{
    public function __construct(
        private readonly BeerRetriever $retriever,
        private readonly BeerRetrieverTransform $transform
    ) {}

    public function __invoke(BeerRetrieverQuery $command): array
    {
        $beers = $this->retriever->__invoke();

        return $this->transform->transform($beers);
    }
}