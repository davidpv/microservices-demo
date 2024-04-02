<?php

declare(strict_types=1);

namespace App\Apps\Api\Posts;

use App\Modules\Post\Application\PostList\ListPostsQuery;
use App\Modules\Post\Domain\Post;
use Shared\Infrastructure\Bus\Query\QueryBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use function Lambdish\Phunctional\map;

class GetListPostsController extends AbstractController
{

    public function __construct(private readonly QueryBus $queryBus)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $query = new ListPostsQuery();

        $response = $this->queryBus->handle($query);

        return new JsonResponse(map(
            fn (Post $post): array  => [
                'id' => $post->id->value(),
                'userId' => $post->userId->value(),
                'title' => $post->title,
                'content' => $post->content,
                'publishedAt' => $post->publishedAt->format(\DateTimeImmutable::ATOM),
            ],
            $response
        ),
            Response::HTTP_OK);
    }

}