<?php

namespace App\Infrastructure\Provider\Beer;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerRepository;
use App\Shared\Infrastructure\Http\ApiRequest;

class BeerApiRepository extends ApiRequest implements BeerRepository
{
    public function retrieve(): array
    {
        $request = $this->get($_ENV["API_REQUEST"]);
        $result = [];
        $contentRequest = json_decode($request->getContent());
        if (isset($contentRequest["error"])) {
            throw new \Exception("ERROR 500");
        }
        foreach ($contentRequest as $item) {
            $price = ltrim($item->price, "$");
            $result[] = Beer::create($price, $item->name, $item->image, $item->id);
        }
        return $result;
    }
}
