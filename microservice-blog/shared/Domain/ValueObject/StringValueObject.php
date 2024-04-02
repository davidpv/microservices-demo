<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class StringValueObject implements ValueObject
{

    public function __construct(protected readonly string $value)
    {
    }

    public function isNull(): bool
    {
        return (null === $this->value());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->value() === $this->value();
    }
}
