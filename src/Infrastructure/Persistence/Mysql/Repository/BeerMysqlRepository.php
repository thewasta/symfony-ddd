<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Mysql\Repository;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerMysqlRepository as BeerMysqlRepositoryAlias;
use Doctrine\DBAL\Connection;

class BeerMysqlRepository implements BeerMysqlRepositoryAlias
{
    public function __construct(private readonly Connection $connection) {}

    public function create(Beer $beer): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->insert('user');
    }
}
