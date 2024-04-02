<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserEnable;

use App\Modules\User\Domain\UserEnabledEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class OnUserEnabledEnablePosts
{

    public function __construct(public MessageBusInterface $bus)
    {
    }

    public function __invoke(UserEnabledEvent $event)
    {
        $message = new UserEnabledMessage($event->aggregateId());
        $this->bus->dispatch($message, [new AmqpStamp('users_enabled')]);
    }

}