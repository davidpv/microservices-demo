<?php

namespace App\Modules\User\Domain;

use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Domain\ValueObject\ValueObject;

class UserCreatedAt extends DateTimeValueObject
{

    public static function create($value): ValueObject
    {
        return self::now();
    }

}
