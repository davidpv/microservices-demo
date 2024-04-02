<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Events;
use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Infrastructure\Bus\Event\EventBus;

#[AsDoctrineListener(event: Events::postPersist, priority: 500, connection: 'default')]
final readonly class DoctrinePostPersistLifecycleListener
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $aggregateRoot = $args->getObject();

        if (!$aggregateRoot instanceof AggregateRoot) {
            return;
        }

        $this->eventBus->publish(...$aggregateRoot->pullDomainEvents());
    }
}
