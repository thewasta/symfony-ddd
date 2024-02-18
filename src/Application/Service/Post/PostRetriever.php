<?php

declare(strict_types=1);

namespace App\Application\Service\Post;

use App\Domain\Model\Post\Post;
use App\Domain\Model\Post\PostRepository;

class PostRetriever
{
    public function __construct(private readonly PostRepository $repository) {}

    /**
     * @return Post[]
     */
    public function __invoke(): array
    {
        return $this->repository->getAll();
    }
}
