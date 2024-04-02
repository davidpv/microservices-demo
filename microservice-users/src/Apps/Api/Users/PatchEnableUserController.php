<?php

namespace App\Apps\Api\Users;

use App\Modules\User\Application\UserEnable\EnableUserCommand;
use App\Modules\User\Infrastructure\Request\EnableUserPatchRequest;
use Shared\Infrastructure\Bus\Command\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PatchEnableUserController  extends AbstractController
{

    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    public function __invoke(EnableUserPatchRequest $request) : JsonResponse
    {
        $request->validate();

        $command = new EnableUserCommand($request->get('userId'));
        $this->commandBus->execute($command);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}