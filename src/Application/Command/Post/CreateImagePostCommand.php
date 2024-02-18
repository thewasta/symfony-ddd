<?php

declare(strict_types=1);

namespace App\Application\Command\Post;

use App\Domain\Model\Post\ValueObject\PostContentMessage;
use App\Domain\Model\User\User;
use App\Domain\Model\User\ValueObject\UserAuth0Id;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;

class CreateImagePostCommand
{
    public function __construct(
        private readonly UploadedFile $image,
        private readonly string $uploadPath,
        private readonly string $message,
        private readonly UserInterface $user
    ) {}

    public function image(): UploadedFile
    {
        return $this->image;
    }

    public function uploadPath(): string
    {
        return $this->uploadPath;
    }

    public function message(): PostContentMessage
    {
        return PostContentMessage::from($this->message);
    }

    public function userId(): UserAuth0Id
    {
        /**
         * @var User $user
         */
        $user = $this->user;

        return UserAuth0Id::from($user->userId()->value());
    }
}
