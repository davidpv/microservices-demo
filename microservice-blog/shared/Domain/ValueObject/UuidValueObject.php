<?php declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use InvalidArgumentException;
use Stringable;
use Symfony\Component\Uid\Uuid;

class UuidValueObject
{
    public function __construct(protected ?string $value = null)
    {
        if (null === $value) {
            $this->value = self::generate()->value();
        }

        $this->ensureIsValidUuid();
    }

    public static function generate(): self
    {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }

    public static function fromString(string $value = null): self
    {
        return new self($value);
    }

    public function value(): string
    {
        return $this->value ?? self::generate()->value();
    }

    public function __toString(): string
    {
        return $this->value ?? self::generate()->value();
    }

    private function ensureIsValidUuid(): void
    {
        if (null === $this->value || !uuid_is_valid($this->value)) {
            throw new \InvalidArgumentException(sprintf(self::class.' does not allow the value <%s>.', $this->value));
        }
    }
}
