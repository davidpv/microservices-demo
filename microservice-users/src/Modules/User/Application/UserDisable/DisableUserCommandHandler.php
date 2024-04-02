<?php

namespace App\Modules\User\Application\UserDisable;

use App\Modules\User\Domain\UserId;
use App\Modules\User\Domain\UserRepository;
use Shared\Infrastructure\Bus\Command\CommandHandler;

readonly class DisableUserCommandHandler implements CommandHandler
{

    public function __construct(
        public UserRepository $userRepository
    )
    {
    }

    public function __invoke(DisableUserCommand $command): void
    {
        $user = $this->userRepository->getById(UserId::fromString($command->userId));
        assert($user !== null);

        $user->disableUser();
        $this->userRepository->save($user);
    }

}