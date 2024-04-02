<?php

namespace Shared\Domain\Bus\Event;

use DateTimeImmutable;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Utils;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Bus\Event\DomainEventInterface;

abstract class DomainEvent implements DomainEventInterface
{

    private string $eventId;
    private string $occurredOn;

    public function __construct(
        private string $aggregate,
        string         $eventId = null,
        string         $occurredOn = null)
    {
        $this->eventId = $eventId ?: UuidValueObject::generate()->value();
        $this->occurredOn = $occurredOn ?: Utils::dateToString(new DateTimeImmutable());
    }

    abstract public static function from(AggregateRoot $aggregate): self;

    abstract public static function eventName(): string;

    abstract public function to(): array;

    public function aggregateId(): string
    {
        return $this->aggregate;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
