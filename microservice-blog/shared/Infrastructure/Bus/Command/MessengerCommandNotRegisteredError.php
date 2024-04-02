<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Command;

use RuntimeException;

final class MessengerCommandNotRegisteredError extends RuntimeException
{
    public function __construct(Command $command)
    {
        $commandClass = get_class($command);

        parent::__construct("The command <$commandClass> hasn't a command handler associated");
    }
}
