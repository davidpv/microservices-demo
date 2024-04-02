<?php

namespace App\Apps\Api\Users;

use App\Modules\User\Application\UserSearchByCriteria\UserGetByResponse;
use App\Modules\User\Domain\ListUsersQuery;
use App\Modules\User\Domain\User;
use App\Modules\User\Infrastructure\Request\ListUserGetRequest;
use DateTimeImmutable;
use Shared\Infrastructure\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

class GetUsersController extends AbstractController
{

    public function __construct(
        private readonly QueryBus $queryBus
    )
    {

    }

    public function __invoke(ListUserGetRequest $request): JsonResponse
    {
        $request->validate();

        $orderBy = $request->getRequest()->get('order_by');
        $order = $request->getRequest()->get('order');
        $limit = $request->get('limit');
        $offset = $request->get('offset');

        $query = new ListUsersQuery(
            (array) $request->get('filters'),
            $orderBy,
            $order,
            $limit === null ? null : (int) $limit,
            $offset === null ? null : (int) $offset
        );

        /** @var UserGetByResponse $response */
        $response = $this->queryBus->handle($query);

        return new JsonResponse(
            map(
                fn (User $user): array  => [
                    'id' => $user->id->value(),
                    'username' => $user->username->value(),
                    'email' => $user->email->value(),
                    'full_name' => $user->getFullName(),
                    'is_enabled' => $user->isEnabled()
                ],
                $response->items
            ),
            Response::HTTP_OK
        );
    }
}
