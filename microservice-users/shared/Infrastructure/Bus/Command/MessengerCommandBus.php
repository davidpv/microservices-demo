<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Command;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBusInterface;

final class MessengerCommandBus implements CommandBus
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    public function execute(Command $command): void
    {
        try {
            $this->commandBus->dispatch($command);
        } catch (NoHandlerForMessageException) {
            throw new MessengerCommandNotRegisteredError($command);
        } catch (HandlerFailedException $error) {
            throw $error->getPrevious() ?? $error;
        }
    }
}
