<?php

namespace App\Modules\User\Application\UserDisable;

use Shared\Infrastructure\Bus\Command\Command;

readonly class DisableUserCommand implements Command
{

    public function __construct(
        public string $userId
    )
    {
    }

}