<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

use RuntimeException;

final class MessengerEventNotRegisteredError extends RuntimeException
{
    public function __construct(DomainEventInterface $event)
    {
        $eventClass = get_class($event);

        parent::__construct("The event <$eventClass> hasn't a event handler associated");
    }
}
