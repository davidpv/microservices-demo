<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class NumberValueObject implements ValueObject
{
    public function __construct(protected int $value)
    {
    }

    public function isBiggerThan(NumberValueObject $other): bool
    {
        return $this->value() > $other->value();
    }

    public function value(): int
    {
        return $this->value;
    }

    public function isNull(): bool
    {
        return (null === $this->value());
    }

    public function isSame(ValueObject $object): bool
    {
        return ($this->value() === $object->value());
    }

}
