<?php

declare(strict_types=1);

namespace Shared\Domain\Criteria;


use Shared\Domain\Pagination\Pagination;

readonly class Criteria
{
    private ?FilterCollection $filterCollection;

    private ?Pagination $pagination;

    public function __construct(
        FilterCollection $filterCollection = null,
        Pagination $pagination = null
    ) {
        $this->filterCollection = $filterCollection;
        $this->pagination       = $pagination;
        $this->validateAllowedFields();
    }

    private function validateAllowedFields()
    {
    }

    public function hasFilters(): bool
    {
        if (null !== $this->filterCollection) {
            return $this->filterCollection->count() > 0;
        }

        return false;
    }

    public function hasPagination(): bool
    {
        return null !== $this->pagination;
    }

    public function getGroupedFilters(): array
    {
        $filters = (array) $this->filterCollection?->getIterator();

        /* @var Filter $filter */
        return array_reduce($filters, function (array $accumulator, Filter $filter) {
            $accumulator[$filter->getField()->value()][] = $filter;

            return $accumulator;
        }, []);
    }

    public function getFilters(array $fields = null, array $operators = null): ?FilterCollection
    {
        $filterList         = (array) $this->filterCollection?->getIterator();
        $filterListFiltered = [];

        if (!empty($fields)) {
            $filterListFiltered = array_filter(
                $filterList,
                static function ($filter) use ($fields) {
                    foreach ($fields as $field) {
                        /** @var Filter $filter */
                        if ($filter->getField()->value() === $field) {
                            return true;
                        }
                    }

                    return false;
                }
            );
        }

        if (!empty($operators)) {
            $filterListFiltered = array_filter(
                $filterList,
                static function ($filter) use ($operators) {
                    foreach ($operators as $operator) {
                        /** @var Filter $filter */
                        if ($filter->getOperator()->value() === $operator) {
                            return true;
                        }
                    }

                    return false;
                }
            );
        }

        return new FilterCollection(array_values($filterListFiltered));
    }

    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

}
