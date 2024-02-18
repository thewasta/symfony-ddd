<?php

declare(strict_types=1);

namespace App\Domain\Service\Post;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;

class PostCreator
{
    public function __construct(private readonly PostRepository $repository) {}

    public function __invoke(Post $post): void
    {
        $this->repository->save($post);
    }
}
