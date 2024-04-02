<?php

declare(strict_types=1);

namespace App\Modules\Post\Application\PostList;

use App\Modules\Post\Domain\PostRepository;
use Shared\Infrastructure\Bus\Query\QueryHandler;

readonly  class ListPostsQueryHandler implements QueryHandler
{

    public function __construct(public PostRepository $postRepository)
    {
    }

    public function __invoke(ListPostsQuery $query)
    {
       return $this->postRepository->getAll();
    }

}