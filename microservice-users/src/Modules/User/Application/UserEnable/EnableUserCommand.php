<?php

namespace App\Modules\User\Application\UserEnable;

use Shared\Infrastructure\Bus\Command\Command;

readonly class EnableUserCommand implements Command
{

    public function __construct(
        public string $userId
    )
    {
    }

}