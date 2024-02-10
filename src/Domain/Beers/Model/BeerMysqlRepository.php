<?php

namespace App\Domain\Beers\Model;

use App\Domain\Beers\Model\ValueObject\BeerId;

interface BeerMysqlRepository
{
    public function find(BeerId $id): ?Beer;

    public function create(Beer $beer): void;
}
