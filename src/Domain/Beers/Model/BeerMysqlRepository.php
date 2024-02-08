<?php

namespace App\Domain\Beers\Model;

interface BeerMysqlRepository
{
    public function create(Beer $beer): void;
}
