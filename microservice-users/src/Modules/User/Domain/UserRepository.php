<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use App\Modules\User\Application\UserSearchByCriteria\UserGetByResponse;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\ValueObject\UuidValueObject;

interface UserRepository
{

    public function getById(UuidValueObject $id): ?User;

    public function getBy(Criteria $criteria): UserGetByResponse;

    public function save(User $user): void;

}
