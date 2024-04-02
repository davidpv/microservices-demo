<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserCreate;

use Shared\Infrastructure\Bus\Command\Command;

readonly class UserCreateCommand implements Command
{

    public function __construct(
        public string $id,
        public string $username,
        public string $email,
        public string $firstName,
        public string $lastName
    )
    {
    }

}