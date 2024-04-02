<?php declare(strict_types=1);

namespace Shared\Domain\Pagination;


class Sort
{
    public const ORDER_ASC = 'ASC';
    public const ORDER_DESC = 'DESC';

    public readonly ?string $sort;
    public readonly ?string $order;

    public function __construct(
        string $sort = null,
        ?string $order = self::ORDER_ASC
    ) {
        $this->sort = $sort;
        $this->order = $order;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function getOrder(): ?string
    {
        return $this->order;
    }
}
