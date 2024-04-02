<?php

declare(strict_types=1);

namespace App\Apps\Api\Posts;

use App\Modules\Post\Application\PostCreate\PostCreateCommand;
use App\Modules\Post\Infrastructure\Request\CreatePostRequest;
use DateTimeImmutable;
use Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostCreatePostController extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(CreatePostRequest $request): JsonResponse
    {
        $request->validate();

        $command = new PostCreateCommand(
            $request->get('id'),
            $request->get('userId'),
            $request->get('title'),
            $request->get('content')
        );

        $this->commandBus->execute($command);

        return new JsonResponse([], Response::HTTP_CREATED);

    }

}