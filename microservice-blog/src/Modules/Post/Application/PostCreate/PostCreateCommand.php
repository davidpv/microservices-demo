<?php

declare(strict_types=1);

namespace App\Modules\Post\Application\PostCreate;

use DateTimeImmutable;
use Shared\Infrastructure\Bus\Command\Command;
class PostCreateCommand implements Command
{

    public readonly DateTimeImmutable $publishedAt;

    public function __construct(
        public readonly string $id,
        public readonly string $userId,
        public readonly string $title,
        public readonly string $content
    )
    {
        $this->publishedAt = new DateTimeImmutable();
    }

}