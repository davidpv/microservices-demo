<?php

declare(strict_types=1);

namespace App\Apps\Api\Users;

use App\Modules\User\Application\UserCreate\UserCreateCommand;
use App\Modules\User\Infrastructure\Request\CreateUserPostRequest;
use Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PostCreateUserController extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(CreateUserPostRequest $request): JsonResponse
    {
        $request->validate();

        $command = new UserCreateCommand(
            $request->get('id'),
            $request->get('username'),
            $request->get('email'),
            $request->get('firstName'),
            $request->get('lastName'),
        );
        $this->commandBus->execute($command);

        return new JsonResponse([], Response::HTTP_CREATED);
    }


}