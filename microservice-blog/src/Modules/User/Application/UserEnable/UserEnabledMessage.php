<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserEnable;

readonly class UserEnabledMessage
{

    public function __construct(
        public string $userId
    )
    {
    }

}