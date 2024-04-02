<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserCreate;

use App\Modules\User\Domain\User;
use App\Modules\User\Domain\UserRepository;
use Shared\Infrastructure\Bus\Command\CommandHandler;

readonly class UserCreateCommandHandler implements CommandHandler
{
   public function __construct(public UserRepository $userRepository){

   }

   public function __invoke(UserCreateCommand $command) :void
   {
       $user = User::create(
           $command->id,
           $command->username,
           $command->email,
           $command->firstName,
           $command->lastName,
           false
       );

       $this->userRepository->save($user);
   }


}