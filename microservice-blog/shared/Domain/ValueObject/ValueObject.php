<?php

namespace Shared\Domain\ValueObject;

interface ValueObject
{
    public function isNull(): bool;

    public function isSame(ValueObject $object): bool;

    public function value();

    public static function create($value): self;

}
