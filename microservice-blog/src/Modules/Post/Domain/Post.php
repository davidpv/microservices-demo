<?php

declare(strict_types=1);

namespace App\Modules\Post\Domain;

use DateTimeImmutable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\UuidValueObject;

final class Post extends AggregateRoot
{
    public function __construct(
        public readonly UuidValueObject $id,
        public readonly UuidValueObject $userId,
        public readonly string $title,
        public readonly string $content,
        public readonly DateTimeImmutable $publishedAt,
        private bool $visible
    ) {
    }

    public static function create(
        string $userId,
        string $title,
        string $content,
        DateTimeImmutable $publishedAt
    ): self
    {
        $post = new self(
            UuidValueObject::generate(),
            UuidValueObject::fromString($userId),
            $title,
            $content,
            $publishedAt,
            $visible = true
        );

        $post->record(PostCreatedEvent::from($post));

        return $post;
    }

    public function visible(): bool
    {
        return $this->visible;
    }

    public function show(): void
    {
        $this->visible = true;
        //todo: event post.shown
    }

    public function hide(): void
    {
        $this->visible = false;
        //todo: event post.hidden
    }
}