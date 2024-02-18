<?php

declare(strict_types=1);

namespace App\Domain\Model\Post;

interface PostRepository
{
    public function save(Post $post): void;
}
