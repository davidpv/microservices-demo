<?php declare(strict_types=1);

namespace App\Modules\User\Application\UserSearchByCriteria;

use App\Modules\User\Domain\ListUsersCriteria;
use App\Modules\User\Domain\ListUsersQuery;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Pagination\Pagination;
use Shared\Infrastructure\Bus\Query\QueryHandler;

readonly class ListUsersQueryHandler implements QueryHandler
{

    public function __construct(
        private UsersByCriteriaSearcher $searcher
    )
    {
    }

    public function __invoke(ListUsersQuery $query) : UserGetByResponse
    {
        $filters = Filters::fromValues($query->filters());

        $pagination =  new Pagination($query->limit(), $query->offset());
        $criteria = new Criteria($filters, $pagination);

        $res =  $this->searcher->search($criteria);

        return $res;
    }

}
