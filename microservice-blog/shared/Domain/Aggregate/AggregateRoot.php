<?php

declare(strict_types=1);

namespace Shared\Domain\Aggregate;


use Shared\Infrastructure\Bus\Event\DomainEventInterface;

abstract class AggregateRoot
{
    private array $domainEvents = [];

    final public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEventInterface $domainEvent): void
    {
        $this->domainEvents[] = $domainEvent;
    }
}
