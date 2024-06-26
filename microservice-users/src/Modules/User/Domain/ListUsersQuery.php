<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Infrastructure\Bus\Query\Query;
use Shared\Infrastructure\Request\BaseRequest;

readonly class ListUsersQuery implements Query
{

    public function __construct(
        private array $filters,
        private ?string $orderBy,
		private ?string $order,
		private ?int $limit,
		private ?int $offset
    )
    {
    }
    public function filters(): array
    {
        return $this->filters;
    }

    public function orderBy(): ?string
    {
        return $this->orderBy;
    }

    public function order(): ?string
    {
        return $this->order;
    }

    public function limit(): ?int
    {
        return $this->limit;
    }

    public function offset(): ?int
    {
        return $this->offset;
    }

}
