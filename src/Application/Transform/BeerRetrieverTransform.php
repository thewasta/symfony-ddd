<?php

namespace App\Application\Transform;

use App\Domain\Beers\Model\Beer;

class BeerRetrieverTransform
{
    /**
     * @param Beer[] $transform
     * @return array
     */
    public function transform(array $transform): array
    {
        $response = [];
        foreach ($transform as $item) {
            $response[] = [
                "price" => $item->price()->value(),
                "name" => $item->name()->value(),
                "image" => $item->image()->value()
            ];
        }
        return $response;
    }
}
