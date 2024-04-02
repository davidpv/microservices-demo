<?php

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\StringValueObject;

class UserLastName extends StringValueObject
{


    public static function create($value): self
    {
        return new self($value);
    }
}
