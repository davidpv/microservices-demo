<?php

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\BooleanValueObject;
use Shared\Domain\ValueObject\ValueObject;

class UserEnabled extends BooleanValueObject
{

    public static function create($value): self
    {
        return new self($value);
    }
}
