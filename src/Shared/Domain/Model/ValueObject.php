<?php

namespace App\Shared\Domain\Model;

use JsonSerializable;

interface ValueObject extends JsonSerializable
{
    public function value(): mixed;
}
