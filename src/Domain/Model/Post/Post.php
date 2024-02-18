<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

use App\Domain\Model\Post\ValueObject\PostContentMessage;
use App\Domain\Model\Post\ValueObject\PostLikes;
use App\Domain\Model\Post\ValueObject\PostMediaPath;
use App\Domain\Model\Post\ValueObject\PostUserUuid;
use App\Domain\Model\Post\ValueObject\PostUuid;
use App\Shared\Domain\Model\Model;

final class Post extends Model
{
    private function __construct(
        private readonly PostUuid $id,
        private readonly PostUserUuid $userId,
        private readonly PostContentMessage $message,
        private readonly PostMediaPath $mediaPath,
        private readonly PostLikes $likes,
    ) {}

    public static function create(
        PostUuid $id,
        PostUserUuid $userId,
        PostContentMessage $message,
        PostMediaPath $mediaPath,
        PostLikes $likes,
    ): self {
        $post = new self($id, $userId, $message, $mediaPath, $likes);
        //$post->publish();
        return $post;
    }

    public function id(): PostUuid
    {
        return $this->id;
    }

    public function userId(): PostUserUuid
    {
        return $this->userId;
    }

    public function message(): PostContentMessage
    {
        return $this->message;
    }

    public function mediaPath(): PostMediaPath
    {
        return $this->mediaPath;
    }

    public function likes(): PostLikes
    {
        return $this->likes;
    }

    public function toArray(): array
    {
        return [
            "userId" => $this->userId()->value(),
            "message" => $this->message()->value(),
            "mediaPath" => $this->mediaPath()->value(),
            "likes" => $this->likes()->value(),
        ];
    }
}
