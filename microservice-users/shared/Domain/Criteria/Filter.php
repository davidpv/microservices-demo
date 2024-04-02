<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

final readonly class Filter
{
    public function __construct(
        private FilterField $field,
        private FilterOperator $operator,
        private FilterValue $value
    ) {
    }

    public static function fromValues(string $field, string $operator, mixed $value): self
    {
        return new self(
            new FilterField($field),
            FilterOperator::fromString($operator),
            new FilterValue($value)
        );
    }

    public function getField(): FilterField
    {
        return $this->field;
    }

    public function getOperator(): FilterOperator
    {
        return $this->operator;
    }

    public function getValue(): FilterValue
    {
        return $this->value;
    }

    public function serialize(): string
    {
        return sprintf('%s.%s.%s', $this->field->value(), $this->operator->value(), $this->value->value());
    }
}
