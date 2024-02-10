<?php

namespace App\Infrastructure\Provider\Beer;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerRepository;
use App\Domain\Beers\Model\ValueObject\BeerId;
use App\Domain\Beers\Model\ValueObject\BeerImage;
use App\Domain\Beers\Model\ValueObject\BeerName;
use App\Domain\Beers\Model\ValueObject\BeerPrice;
use App\Infrastructure\Provider\Exception\BeerApiNotFound;
use App\Shared\Infrastructure\Http\ApiRequest;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class BeerApiRepository extends ApiRequest implements BeerRepository
{
    /**
     * @return array
     * @throws BeerApiNotFound
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function retrieve(): array
    {
        $request = $this->get($_ENV["API_REQUEST"]);
        $result = [];
        $contentRequest = json_decode($request->getContent());
        if (
            gettype($contentRequest) !== "array" &&
            $contentRequest->error !== null
        ) {
            throw new BeerApiNotFound("ERROR 500");
        }

        foreach ($contentRequest as $item) {
            $price = ltrim($item->price, "$");
            $result[] = Beer::create(
                BeerPrice::from($price),
                BeerName::from($item->name),
                BeerImage::from($item->image),
                BeerId::from($item->id)
            );
        }
        return $result;
    }
}
