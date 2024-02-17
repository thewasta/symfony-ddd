<?php

namespace App\Shared\Domain\Model\ValueObject;

use App\Shared\Domain\Model\ValueObject;

class BoolValueObject implements ValueObject
{
    final private function __construct(private readonly bool $value) {}

    public static function from(bool $value): static
    {
        return new static($value);
    }

    public function value(): bool
    {
        return $this->value;
    }

    public function equalTo(self $other): bool
    {
        return __CLASS__ === get_class($other) && $this->value === $other->value();
    }

    public function toLiteral(): string
    {
        return $this->value ? '1' : '0';
    }

    public function jsonSerialize(): bool
    {
        return $this->value;
    }
}
