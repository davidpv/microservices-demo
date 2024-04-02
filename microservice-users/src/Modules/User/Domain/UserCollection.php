<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Domain\Collection;

class UserCollection extends Collection
{

    protected function type(): string
    {
        return User::class;
    }
}
