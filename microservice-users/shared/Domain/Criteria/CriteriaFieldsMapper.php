<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

interface CriteriaFieldsMapper
{
    public static function create(): self;

    public function mapField(string $field): string;

    public function addField(string $field, string $propertyName): void;

    public function updateField(string $field, string $propertyName): void;

    public function removeField(string $field): void;

    public function isField(string $field): bool;
}
