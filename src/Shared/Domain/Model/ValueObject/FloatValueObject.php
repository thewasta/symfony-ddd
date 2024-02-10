<?php

namespace App\Shared\Domain\Model\ValueObject;

use App\Shared\Domain\Model\ValueObject;

class FloatValueObject implements ValueObject
{
    final private function __construct(private readonly float $value) {}

    public static function from(float $value): static
    {
        return new static($value);
    }

    public function value(): float
    {
        return $this->value;
    }

    public function jsonSerialize(): float
    {
        return $this->value;
    }
}
