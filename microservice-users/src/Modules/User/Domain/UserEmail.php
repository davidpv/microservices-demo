<?php

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\EmailValueObject;
use Shared\Domain\ValueObject\ValueObject;

class UserEmail extends EmailValueObject
{

    public static function create($value): EmailValueObject
    {
        return new self($value);
    }
}
