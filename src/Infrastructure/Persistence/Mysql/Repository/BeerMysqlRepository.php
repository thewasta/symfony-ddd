<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Mysql\Repository;

use App\Domain\Beers\Model\Beer;
use App\Domain\Beers\Model\BeerMysqlRepository as BeerMysqlRepositoryAlias;
use App\Domain\Beers\Model\ValueObject\BeerId;
use Doctrine\DBAL\Connection;

class BeerMysqlRepository implements BeerMysqlRepositoryAlias
{
    public function __construct(private readonly Connection $connection) {}

    public function find(BeerId $id): ?Beer
    {
        return null;
    }

    public function create(Beer $beer): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->insert('user');
    }
}
