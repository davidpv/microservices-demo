<?php declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use DateTime;
use Exception;

class DateTimeValueObject implements ValueObject
{

    private const DATABASE_FORMAT = 'Y-m-d h:i:s';
    private DateTime $dateTime;

    public function __construct(?DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public static function createFromDatetime(DateTime $value): self
    {
        return new self($value);
    }

    /**
     * @throws Exception
     */
    public static function now(): self
    {
        return self::createFromString('now');
    }

    /**
     * @throws Exception
     */
    public static function createFromString(string $value): self
    {
        return new self(new DateTime($value));
    }

    public static function create($value): ValueObject
    {
        return self::createFromString($value);
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->value() === $this->value();
    }

    public function value(): string
    {
        return $this->dateTime->format(self::DATABASE_FORMAT);
    }

    public function isNull(): bool
    {
        return (null === $this->value());
    }
}
