<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;



use Shared\Domain\ValueObject\Enum;

/**
 * @method static FilterOperator gt()
 * @method static FilterOperator lt()
 * @method static FilterOperator like()
 */
final class FilterOperator extends Enum
{
    public const CONTAINS    = 'CONTAINS';
    public const NOT_CONTAINS    = 'NOT_CONTAINS';
    public const EQUAL       = '=';
    public const GT          = '>';
    public const GTE         = '>=';
    public const IN          = 'IN';
    public const IS_NOT_NULL = ' IS NOT NULL';
    public const IS_NULL     = 'IS NULL';
    public const LT          = '<';
    public const LTE         = '<=';
    public const NOT_EQUAL   = '!=';
    public const NOT_IN      = 'NOT IN';

    protected function throwExceptionForInvalidValue($value): void
    {
        throw new \InvalidArgumentException(sprintf('The filter <%s> is invalid', $value));
    }
}
