<?php

namespace App\Modules\User\Application\UserEnable;

use App\Modules\User\Domain\UserId;
use App\Modules\User\Domain\UserRepository;
use Shared\Infrastructure\Bus\Command\CommandHandler;

readonly class EnableUserCommandHandler implements CommandHandler
{

    public function __construct(
        public UserRepository $userRepository
    )
    {
    }

    public function __invoke(EnableUserCommand $command): void
    {
        $user = $this->userRepository->getById(UserId::fromString($command->userId));
        assert($user !== null);

        $user->enableUser();
        $this->userRepository->save($user);
    }

}