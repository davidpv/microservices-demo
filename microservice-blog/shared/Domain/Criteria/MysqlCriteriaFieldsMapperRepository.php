<?php

namespace Shared\Domain\Criteria;


use function Shared\Tools\arrayKeyExists;

abstract class MysqlCriteriaFieldsMapperRepository implements CriteriaFieldsMapper
{
    private array $map = [];

    protected function __construct()
    {
    }

    public function mapField(string $field): string
    {
        if (false === $this->isField($field)) {
            throw new \LogicException(sprintf('%s field not mapped for use in criteria', $field));
        }

        return $this->map[$field];
    }

    public function addField(string $field, string $propertyName): void
    {
        if (true === $this->isField($field)) {
            throw new \LogicException(sprintf('%s field is already mapped for use in criteria', $field));
        }

        $this->map[$field] = $propertyName;
    }

    public function updateField(string $field, string $propertyName): void
    {
        if (true === $this->isField($field)) {
            throw new \LogicException(sprintf('%s field is already mapped for use in criteria', $field));
        }

        $this->map[$field] = $propertyName;
    }

    public function removeField(string $field): void
    {
        if (false === $this->isField($field)) {
            throw new \LogicException(sprintf('%s field not mapped for use in criteria', $field));
        }
        unset($this->map[$field]);
    }

    public function isField(string $field): bool
    {
        return arrayKeyExists($field, $this->map);
    }
}
