<?php

declare(strict_types=1);

namespace App\Modules\Event\Application;

use App\Modules\Event\Domain\Event;
use App\Modules\Event\Domain\EventRepository;
use Shared\Infrastructure\Bus\Event\DomainEventInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DomainEventToEventStoreSubscriber
{
    public function __construct(public EventRepository $eventRepository)
    {
    }

    public function __invoke(DomainEventInterface $domainEvent): void
    {
        $event = Event::create(
            $domainEvent->eventName(),
            $domainEvent->aggregateId(),
            $domainEvent->to(),
            new \DateTimeImmutable($domainEvent->occurredOn())
        );

        $this->eventRepository->save($event);
    }
}