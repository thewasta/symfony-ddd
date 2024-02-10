<?php

declare(strict_types=1);

namespace App\Domain\Beers\Model;

use App\Domain\Beers\Events\BeerCreated;
use App\Domain\Beers\Model\ValueObject\BeerId;
use App\Domain\Beers\Model\ValueObject\BeerImage;
use App\Domain\Beers\Model\ValueObject\BeerName;
use App\Domain\Beers\Model\ValueObject\BeerPrice;
use App\Shared\Domain\Model\Model;

final class Beer extends Model
{
    private function __construct(
        private readonly BeerPrice $price,
        private readonly BeerName $name,
        private readonly BeerImage $image,
        private readonly BeerId $id
    ) {}

    public static function create(
        BeerPrice $price,
        BeerName $name,
        BeerImage $image,
        BeerId $id
    ): self {
        $beer = new self($price, $name, $image, $id);

        $beer->publish(new BeerCreated());
        return $beer;
    }

    public function id(): BeerId
    {
        return $this->id;
    }

    public function price(): BeerPrice
    {
        return $this->price;
    }

    public function name(): BeerName
    {
        return $this->name;
    }

    public function image(): BeerImage
    {
        return $this->image;
    }

    public function toArray(): array
    {
        return [
            "price" => $this->price->value(),
            "name" => $this->name->value(),
            "image" => $this->image->value(),
            "id" => $this->id->value(),
        ];
    }
}
