<?php

declare(strict_types=1);

namespace App\Modules\Post\Domain;

interface PostRepository
{
    public function save(Post $post): void;
}