<?php

declare(strict_types=1);

namespace Shared\Domain\Pagination;

class Pagination
{
    private ?int $limit;
    private ?int $offset;
    private ?SortCollection $sort;

    public function __construct(
        int $limit = null,
        int $offset = null,
        SortCollection $sort = null
    ) {
        $this->limit  = $limit;
        $this->offset = $offset;
        $this->sort   = $sort;
    }

    public static function create(?int $limit, ?int $offset, ?string $sort, ?string $order): self
    {
        $sortCollection = new SortCollection([new Sort($sort, $order)]);

        return new self($limit, $offset, $sortCollection);
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    public function getSort(): ?SortCollection
    {
        return $this->sort;
    }

    public function setSort(?SortCollection $sort): void
    {
        $this->sort = $sort;
    }
}
