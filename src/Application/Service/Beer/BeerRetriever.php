<?php

namespace App\Application\Service\Beer;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerRepository;

class BeerRetriever
{
    public function __construct(private readonly BeerRepository $repository) {}

    /**
     * @return Beer[]
     */
    public function __invoke(): array
    {
        return $this->repository->retrieve();
    }
}
