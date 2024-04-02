<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Event;

interface EventBus
{
    public function publish(DomainEventInterface ...$events): void;
}
