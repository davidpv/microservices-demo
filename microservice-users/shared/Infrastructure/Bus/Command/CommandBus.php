<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Command;

interface CommandBus
{
    public function execute(Command $command): void;
}
