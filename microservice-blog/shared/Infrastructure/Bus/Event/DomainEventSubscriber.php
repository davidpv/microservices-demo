<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

interface DomainEventSubscriber
{
    public static function subscribedTo(): array;
}
