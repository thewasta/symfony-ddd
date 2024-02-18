<?php

declare(strict_types=1);

namespace App\Application\Handler\Post;

use App\Application\Command\Post\CreateImagePostCommand;
use App\Application\Service\Post\PostImageUploader;
use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\ValueObject\PostLikes;
use App\Domain\Model\Post\ValueObject\PostMediaPath;
use App\Domain\Model\Post\ValueObject\PostUserUuid;
use App\Domain\Model\Post\ValueObject\PostUuid;
use App\Domain\Service\Post\PostCreator;
use App\Shared\Application\Handler\AppCommandHandler;
use App\Shared\Domain\Command\MessageBusResponse;

class CreateImagePostHandler extends AppCommandHandler
{
    public function __construct(
        private readonly PostImageUploader $uploader,
        private readonly PostCreator $postCreator
    ) {}

    public function __invoke(CreateImagePostCommand $command): MessageBusResponse
    {
        $path = $this->uploader->__invoke($command->image(), $command->uploadPath(), $command->userId());
        $post = Post::create(
            PostUuid::from(uniqid()),
            PostUserUuid::from($command->userId()->value()),
            $command->message(),
            PostMediaPath::from($path),
            PostLikes::from(0)
        );
        $this->postCreator->__invoke($post);
        return MessageBusResponse::create([]);
    }
}
