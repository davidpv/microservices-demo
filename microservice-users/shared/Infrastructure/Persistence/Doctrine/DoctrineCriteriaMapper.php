<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\Doctrine;

use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\CriteriaFieldsMapper;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Pagination\Pagination;
use Shared\Domain\Pagination\Sort;

final class DoctrineCriteriaMapper
{
    public static function create(Criteria $criteria, CriteriaFieldsMapper $fieldsMapper): DoctrineCriteria
    {
        $filters          = $criteria->getGroupedFilters();
        $doctrineCriteria = DoctrineCriteria::create();

        /* @var Filter $filter */
        foreach ($filters as $filtersByField) {
            $expressions = [];
            foreach ($filtersByField as $filter) {
                $expressions[] = self::expressionBuilder($filter->getOperator(), $fieldsMapper->mapField($filter->getField()->value()), $filter->getValue()->value());
            }
            if (count($expressions) > 0) {
                $doctrineCriteria->andWhere(DoctrineCriteria::expr()->orX(...$expressions));
            }
        }

        if ($criteria->hasPagination()) {
            /** @var Pagination $pagination */
            $pagination = $criteria->getPagination();
            if ((bool) $pagination->getSort()) {
                $sorts = $pagination->getSort();
                assert(null !== $sorts);
                $orderBy = [];
                /** @var Sort $sort */
                foreach ($sorts->getIterator() as $sort) {
                    if (null !== $sort->sort) {
                        $orderBy[$fieldsMapper->mapField($sort->sort)] = self::orderMapper($sort->order);
                    }
                }
                if (count($orderBy) > 0) {
                    $doctrineCriteria->orderBy($orderBy);
                }
            }
            $limit  = $pagination->getLimit();
            $offset = $pagination->getOffset();
            if (null !== $limit) {
                $doctrineCriteria->setMaxResults($limit);
            }
            if (null !== $limit && null !== $offset) {
                $doctrineCriteria->setFirstResult($offset);
            }
        }

        return $doctrineCriteria;
    }

    private static function orderMapper(?string $order): string
    {
        return match ($order) {
            Sort::ORDER_ASC  => DoctrineCriteria::ASC,
            Sort::ORDER_DESC => DoctrineCriteria::DESC,
            default          => throw new \LogicException(sprintf('%s order not supported for use in criteria', $order)),
        };
    }

    private static function expressionBuilder(FilterOperator $operator, string $propertyName, mixed $value): Comparison
    {
        $expressionBuilder = DoctrineCriteria::expr();

        return match ($operator->value()) {
            FilterOperator::CONTAINS    => $expressionBuilder->contains($propertyName, $value),
            FilterOperator::EQUAL       => $expressionBuilder->eq($propertyName, $value),
            FilterOperator::GT          => $expressionBuilder->gt($propertyName, $value),
            FilterOperator::GTE         => $expressionBuilder->gte($propertyName, $value),
            FilterOperator::IN          => $expressionBuilder->in($propertyName, $value),
            FilterOperator::IS_NOT_NULL => $expressionBuilder->neq($propertyName, null),
            FilterOperator::IS_NULL     => $expressionBuilder->isNull($propertyName),
            FilterOperator::LT          => $expressionBuilder->lt($propertyName, $value),
            FilterOperator::LTE         => $expressionBuilder->lte($propertyName, $value),
            FilterOperator::NOT_EQUAL   => $expressionBuilder->neq($propertyName, $value),
            FilterOperator::NOT_IN      => $expressionBuilder->notIn($propertyName, $value),
            default                     => throw new \LogicException(sprintf('%s operator not supported for use in criteria', $operator->value())),
        };
    }
}
