<?php

declare(strict_types=1);

namespace App\Domain\Model\User\ValueObject;

use App\Shared\Domain\Model\ValueObject\DateTimeValueObject;

final class UserUpdatedAt extends DateTimeValueObject
{
    public static function from(string $str): static
    {
        if ('' === $str) {
            return UserUpdatedAt::now();
        }
        return parent::from($str);
    }
}
