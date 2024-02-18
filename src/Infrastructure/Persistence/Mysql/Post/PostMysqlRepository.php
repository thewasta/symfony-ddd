<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Mysql\Post;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;
use App\Domain\Model\Post\ValueObject\PostContentMessage;
use App\Domain\Model\Post\ValueObject\PostLikes;
use App\Domain\Model\Post\ValueObject\PostMediaPath;
use App\Domain\Model\Post\ValueObject\PostUuid;
use App\Domain\Model\User\User;
use App\Domain\Model\User\ValueObject\UserAuth0Id;
use App\Domain\Model\User\ValueObject\UserEmail;
use App\Domain\Model\User\ValueObject\UserEmailVerified;
use App\Domain\Model\User\ValueObject\UserFirstName;
use App\Domain\Model\User\ValueObject\UserLastLogin;
use App\Domain\Model\User\ValueObject\UserLoginCount;
use App\Domain\Model\User\ValueObject\UserNickName;
use App\Domain\Model\User\ValueObject\UserPhoto;
use App\Domain\Model\User\ValueObject\UserUpdatedAt;
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
        $query->setParameter('user_uuid', $post->user()->userId()->value());
        $query->setParameter('file_path', $post->mediaPath()->value());
        $query->setParameter('likes', $post->likes()->value());
        $query->executeStatement();
    }

    public function getAll(): array
    {
        $query = $this->connection->createQueryBuilder();
        $query->select('p.*', 'u.*',)
              ->from(self::TABLE, 'p')
              ->join('p', 'user', 'u', 'u.auth0_id = p.user_uuid');
        $result = $query->fetchAllAssociative();

        $posts = [];
        foreach ($result as $row) {
            $user = User::create(
                UserAuth0Id::from($row["auth0_id"]),
                UserNickName::from($row["username"]),
                UserEmail::from($row["email"]),
                UserPhoto::from($row["profile_photo"] ?? ""),
                UserFirstName::from($row["first_name"]),
                UserUpdatedAt::from($row["updated_at"]),
                UserLastLogin::from($row["last_login"] ?? ""),
                UserEmailVerified::from($row["email_verified"] ?? false),
                UserLoginCount::from(0),
            );
            $posts[] = Post::create(
                PostUuid::from($row["uuid"]),
                $user,
                PostContentMessage::from($row["content_message"] ?? ""),
                PostMediaPath::from("/uploads/post/" . $user->userId()->value() . "/" . $row["file_path"]),
                PostLikes::from($row["likes"]),
            );
        }
        return $posts;
    }
}
