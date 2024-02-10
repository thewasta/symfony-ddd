<?php

namespace App\Shared\Domain\Model\ValueObject;

use App\Shared\Domain\Model\ValueObject;

class IntValueObject implements ValueObject
{
    final private function __construct(private readonly int $value) {}

    public static function from(int $value): static
    {
        return new static($value);
    }

    public function isBiggerThan(IntValueObject $other): bool
    {
        return __CLASS__ === \get_class($other) && $other->value > $this->value;
    }

    public function __toString(): string
    {
        return (string)$this->value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
