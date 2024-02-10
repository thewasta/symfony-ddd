<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Domain\Beers\Model\ValueObject\BeerId;
use App\Domain\Beers\Model\ValueObject\BeerImage;
use App\Domain\Beers\Model\ValueObject\BeerName;
use App\Domain\Beers\Model\ValueObject\BeerPrice;

class BeerCreateCommand
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly float $price,
        private readonly string $image
    ) {}

    public function id(): BeerId
    {
        return BeerId::from($this->id);
    }

    public function name(): BeerName
    {
        return BeerName::from($this->name);
    }

    public function price(): BeerPrice
    {
        return BeerPrice::from($this->price);
    }

    public function image(): BeerImage
    {
        return BeerImage::from($this->image);
    }
}
