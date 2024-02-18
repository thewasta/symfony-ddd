<?php

declare(strict_types=1);

namespace App\Domain\Model\Post\ValueObject;

use App\Shared\Domain\Model\ValueObject\StringValueObject;

final class PostContentMessage extends StringValueObject
{
    public static function fromNullable(?string $value): ?self
    {
        if (null === $value) {
            return null;
        }
        return parent::from($value);
    }
}
