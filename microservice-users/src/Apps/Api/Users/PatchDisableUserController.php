<?php

namespace App\Apps\Api\Users;

use App\Modules\User\Application\UserDisable\DisableUserCommand;
use App\Modules\User\Infrastructure\Request\DisableUserPatchRequest;
use Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PatchDisableUserController extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(DisableUserPatchRequest $request): JsonResponse
    {
        $request->validate();

        $command = new DisableUserCommand($request->get('userId'));
        $this->commandBus->execute($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}