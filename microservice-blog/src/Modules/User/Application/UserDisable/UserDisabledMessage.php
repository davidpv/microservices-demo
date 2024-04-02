<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserDisable;

readonly class UserDisabledMessage
{

    public function __construct(
        public string $userId
    )
    {
    }

}