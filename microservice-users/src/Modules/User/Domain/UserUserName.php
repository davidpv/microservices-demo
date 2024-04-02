<?php

declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\StringValueObject;

class UserUserName extends StringValueObject
{
    public static function create($value): self
    {
        return new self($value);
    }
}
