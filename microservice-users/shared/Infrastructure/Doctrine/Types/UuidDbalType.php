<?php declare(strict_types=1);

namespace Shared\Infrastructure\Doctrine\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Shared\Domain\ValueObject\UuidValueObject;

class UuidDbalType extends Type
{
    private const NAME = 'uuid';

    public function getName(): string
    {
        return self::NAME;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UuidValueObject
    {
        return UuidValueObject::fromString($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return (string)$value;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return 'VARCHAR(36)';
    }

}
