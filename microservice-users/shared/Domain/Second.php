<?php

declare(strict_types=1);

namespace Shared\Domain;

use Shared\Domain\ValueObject\NumberValueObject;
use Shared\Domain\ValueObject\ValueObject;

final class Second extends NumberValueObject
{
    public static function create($value): self
    {
        return new self($value);
    }
}
