<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final readonly class MessengerQueryBus implements QueryBus
{
    public function __construct(private MessageBusInterface $queryBus)
    {
    }

    public function handle(Query $query): mixed
    {
        try {
            $envelope = $this->queryBus->dispatch($query);

            $stamp = $envelope->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException) {
            throw new MessengerQueryNotRegisteredError($query);
        }
    }
}
