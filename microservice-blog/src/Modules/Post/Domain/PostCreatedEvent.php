<?php

declare(strict_types=1);

namespace App\Modules\Post\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\ValueObject\UuidValueObject;

class PostCreatedEvent extends DomainEvent
{
    public function __construct(
        public readonly UuidValueObject $aggregate,
        public readonly UuidValueObject $userId,
        public readonly string $title,
        public readonly string $content,
        public readonly bool $visible
    )
    {
        parent::__construct($aggregate->__toString());
    }

    public static function from(AggregateRoot $aggregate): DomainEvent
    {
        return new self(
            $aggregate->id,
            $aggregate->userId,
            $aggregate->title,
            $aggregate->content,
            $aggregate->visible()
        );
    }

    public static function eventName(): string
    {
        return 'post.created';
    }

    public function to(): array
    {
        return [
            'id' => $this->aggregateId(),
            'userId' => $this->userId,
            'title' => $this->title,
            'content' => $this->content,
            'enabled' => $this->visible
        ];
    }
}