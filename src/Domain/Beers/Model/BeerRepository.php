<?php

namespace App\Domain\Beers\Model;

interface BeerRepository
{
    /**
     * @return Beer[]
     */
    public function retrieve(): array;
}
