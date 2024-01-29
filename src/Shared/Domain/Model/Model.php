<?php

namespace App\Shared\Domain\Model;

abstract class Model
{
    abstract public function toArray(): array;
}
