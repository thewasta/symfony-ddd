<?php

namespace App\Tests\Integration\Application\Query;

use App\Application\Query\BeerRetrieverHandler;
use App\Application\Query\BeerRetrieverQuery;
use App\Application\Service\Beer\BeerRetriever;
use App\Application\Transform\BeerRetrieverTransform;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class BeerRetrieverHandlerTest extends KernelTestCase
{
    private BeerRetrieverHandler $useCase;

    protected function setUp(): void
    {
        self::bootKernel();
        $retriever = self::getContainer()->get(BeerRetriever::class);
        $this->useCase = new BeerRetrieverHandler(
            $retriever,
            new BeerRetrieverTransform()
        );
    }

    public function testCheckCoverage(): void
    {
        $response = $this->useCase->__invoke(new BeerRetrieverQuery());
        self::assertCount(180, $response);
    }

    public function testGivenWrongThrowError(): void
    {
        $_ENV["API_REQUEST"] .= "example";
        $this->expectException(\Exception::class);
        $this->useCase->__invoke(new BeerRetrieverQuery());
    }
}
