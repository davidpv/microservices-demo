<?php

declare(strict_types=1);

namespace App\Modules\Event\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\UuidValueObject;

final class Event extends AggregateRoot
{
    public function __construct(
        public readonly string $eventId,
        public readonly string $aggregate,
        public readonly string $aggregateId,
        public readonly array $payload,
        public readonly \DateTimeImmutable $occurredOn
    )
    {
    }

    public static function create(string $aggregate, string $aggregateId, array $payload, \DateTimeImmutable $occurredOn): self
    {
        $eventId = UuidValueObject::generate()->value();

        return new self($eventId, $aggregate, $aggregateId, $payload, $occurredOn);

    }


}