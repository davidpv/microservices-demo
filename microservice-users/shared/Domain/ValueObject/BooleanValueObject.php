<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class BooleanValueObject implements ValueObject
{

    public function __construct(protected ?bool $value = false)
    {
    }

    public function value(): bool
    {
        return $this->value ?? false;
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->value() === $this->value();
    }

    public function isNull(): bool
    {
        return (false ===  $this->value);
    }
}
