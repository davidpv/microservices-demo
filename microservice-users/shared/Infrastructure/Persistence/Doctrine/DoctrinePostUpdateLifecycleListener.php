<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Infrastructure\Bus\Event\EventBus;

#[AsDoctrineListener(event: Events::postUpdate, priority: 500, connection: 'default')]
final readonly class DoctrinePostUpdateLifecycleListener
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $aggregateRoot = $args->getObject();

        if (!$aggregateRoot instanceof AggregateRoot) {
            return;
        }

        $this->eventBus->publish(...$aggregateRoot->pullDomainEvents());
    }
}
