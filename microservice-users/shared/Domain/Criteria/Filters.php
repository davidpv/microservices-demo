<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;

use Shared\Domain\Collection;
use function Lambdish\Phunctional\reduce;

final class Filters extends Collection
{
    public static function fromValues(array $values): FilterCollection
    {
        return new FilterCollection([]);
//        return new self(array_map(self::filterBuilder(), $values));
//        return new FilterCollection(array_map(self::filterBuilder(), $values));
    }

    private static function filterBuilder(): callable
    {
//        return fn(array $values) => Filter::fromValues($values);
    }

    public function filters(): array
    {
        return $this->items();
    }

    public function serialize(): string
    {
        return reduce(
            static fn(string $accumulate, \Shared\Domain\Criteria\Filter $filter) => sprintf('%s^%s', $accumulate, $filter->serialize()),
            $this->items(),
            ''
        );
    }

    protected function type(): string
    {
        return \Shared\Domain\Criteria\Filter::class;
    }
}
