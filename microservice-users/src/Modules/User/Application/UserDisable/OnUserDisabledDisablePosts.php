<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserDisable;

use App\Modules\User\Domain\UserDisabledEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class OnUserDisabledDisablePosts
{

    public function __construct(public MessageBusInterface $bus)
    {
    }

    public function __invoke(UserDisabledEvent $event)
    {
        $message = new UserDisabledMessage($event->aggregateId());
        $this->bus->dispatch($message, [new AmqpStamp('users_disabled')]);
    }
}
