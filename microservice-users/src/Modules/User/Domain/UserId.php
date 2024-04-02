<?php

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\UuidValueObject;

final class UserId extends UuidValueObject
{
    public static function create($value): self
    {
        return new self($value);
    }

}
