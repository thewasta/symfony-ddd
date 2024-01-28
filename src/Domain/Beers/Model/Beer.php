<?php

namespace App\Domain\Beers\Model;

class Beer
{
    private function __construct(
        private readonly float  $price,
        private readonly string $name,
        private readonly string $image,
        private readonly int    $id
    ) {}

    public static function create(
        float  $price,
        string $name,
        string $image,
        int    $id
    ): self {
        return new static($price, $name, $image, $id);
    }

    public function price(): float
    {
        return $this->price;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function id(): int
    {
        return $this->id;
    }
}
