<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class MessengerDomainEventBus implements EventBus
{
    public function __construct(private MessageBusInterface $eventBus)
    {
    }

    public function publish(DomainEventInterface ...$events): void
    {
        foreach ($events as $event) {
            $this->publisher($event);
        }
    }

    private function publisher(DomainEventInterface $event): void
    {
        try {
            $this->eventBus->dispatch($event);
        } catch (NoHandlerForMessageException) {
            throw new MessengerEventNotRegisteredError($event);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
