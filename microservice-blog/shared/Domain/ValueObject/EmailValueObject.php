<?php declare(strict_types=1);

namespace Shared\Domain\ValueObject;

abstract class EmailValueObject implements ValueObject
{
    private string|bool $userName;
    private string|bool $domain;

    public function __construct(protected readonly string $value)
    {
        $delimiter = strrpos($value, '@');
        if ($delimiter === false) {
            throw new \InvalidArgumentException('EmailValueObject must contain "@" character');
        }
        $this->userName = substr($value, 0, $delimiter);
        $this->domain = substr($value, $delimiter + 1);

        if (trim($this->domain) === '') {
            throw new \InvalidArgumentException('EmailValueObject domain cannot be empty');
        }

        if (trim($this->userName) === '') {
            throw new \InvalidArgumentException('Local part of email cannot be empty');
        }
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function getNormalizedAddress(): string
    {
        return $this->userName . '@' . $this->getNormalizedDomain();
    }

    public function getNormalizedDomain(): string
    {
        return (string)idn_to_ascii($this->domain, (int)IDNA_NONTRANSITIONAL_TO_ASCII, INTL_IDNA_VARIANT_UTS46);
    }

    public function getFullAddress(): string
    {
        return $this->userName . '@' . $this->domain;
    }

    public function isNull(): bool
    {
        return (null === $this->getFullAddress());
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->value() === $this->value();
    }

    public function value(): string
    {
        return $this->value;
    }

}
