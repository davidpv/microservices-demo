<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserSearchByCriteria;

use App\Modules\User\Domain\UserRepository;
use Shared\Domain\Criteria\Criteria;

readonly class UsersByCriteriaSearcher
{

    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function search(?Criteria $criteria = null): UserGetByResponse
    {
        $results =  $this->userRepository->getBy($criteria);
        return $results;
    }


}
