<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerMysqlRepository;
use App\Domain\Beers\Model\ValueObject\BeerId;
use App\Domain\Beers\Model\ValueObject\BeerImage;
use App\Domain\Beers\Model\ValueObject\BeerName;
use App\Domain\Beers\Model\ValueObject\BeerPrice;

class BeerCreateCommandHandler
{
    public function __construct(private readonly BeerMysqlRepository $repository) {}

    public function __invoke(BeerCreateCommand $command): void
    {
        $beer = Beer::create(
            BeerPrice::from(10),
            BeerName::from("Example Beer"),
            BeerImage::from("https://example.com/image"),
            BeerId::from(1)
        );
        $this->repository->create($beer);
    }
}
