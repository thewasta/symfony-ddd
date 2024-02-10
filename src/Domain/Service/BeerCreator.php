<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerMysqlRepository;
use App\Domain\Beers\Model\ValueObject\BeerId;
use App\Domain\Beers\Model\ValueObject\BeerImage;
use App\Domain\Beers\Model\ValueObject\BeerName;
use App\Domain\Beers\Model\ValueObject\BeerPrice;
use App\Domain\Exception\BeerAlreadyExist;

class BeerCreator
{
    public function __construct(private readonly BeerMysqlRepository $repository) {}

    /**
     * @throws BeerAlreadyExist
     */
    public function __invoke(BeerId $id, BeerName $name, BeerImage $image, BeerPrice $price): Beer
    {
        $this->ensureBeerDoesNotExist($id);
        $beer = Beer::create(
            BeerPrice::from(10),
            BeerName::from("Example Beer"),
            BeerImage::from("https://example.com/image"),
            BeerId::from(1)
        );
        $this->repository->create($beer);

        return $beer;
    }

    /**
     * @throws BeerAlreadyExist
     */
    private function ensureBeerDoesNotExist(BeerId $id): void
    {
        if (null !== $this->repository->find($id)) {
            throw new BeerAlreadyExist("Beer with id {$id} already exist on repository");
        }
    }
}
