<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Mysql\Post;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;
use Doctrine\DBAL\Connection;

class PostMysqlRepository implements PostRepository
{
    private const TABLE = 'posts';

    public function __construct(private readonly Connection $connection) {}

    public function save(Post $post): void
    {
        $query = $this->connection->createQueryBuilder();
        $query->insert(self::TABLE);
        $query->values(
            [
                "uuid" => ':uuid',
                "user_uuid" => ":user_uuid",
                "file_path" => ":file_path",
                "likes" => ":likes",
            ]
        );
        $query->setParameter('uuid', $post->id()->value());
        $query->setParameter('user_uuid', $post->userId()->value());
        $query->setParameter('file_path', $post->mediaPath()->value());
        $query->setParameter('likes', $post->likes()->value());
        $query->executeStatement();
    }
}
