<?php

declare(strict_types=1);
namespace App\Modules\Post\Domain;

use App\Modules\Post\Domain\Post;
use Shared\Domain\Collection;

class PostCollection extends Collection
{
    public function getItems(): array
    {
        return $this->items();
    }

    protected function type(): string
    {
        return Post::class;
    }
}