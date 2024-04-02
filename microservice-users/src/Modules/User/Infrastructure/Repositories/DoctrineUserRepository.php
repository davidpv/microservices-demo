<?php declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Repositories;

use App\Modules\User\Application\UserSearchByCriteria\UserGetByResponse;
use App\Modules\User\Domain\User;
use App\Modules\User\Domain\UserCollection;
use App\Modules\User\Domain\UserRepository;
use App\Modules\User\Infrastructure\Doctrine\DoctrineUserCriteriaFieldsMapper;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\QueryException;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineCriteriaMapper;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineUserRepository extends DoctrineRepository implements UserRepository
{

    public function getById(UuidValueObject $id): User
    {
        return $this->entityManager()->find(User::class, $id);
    }

    public function getBy(Criteria $criteria): UserGetByResponse
    {
        $builder = $this->entityManager()->createQueryBuilder()
            ->select('user')
            ->from(User::class, 'user');
        $query = $builder->getQuery();

        $collection = $query->getResult();

        return new UserGetByResponse(new UserCollection($collection), count($collection));
    }

    public function getByCriteria(Criteria $criteria): UserGetByResponse
    {
        $query = $this->queryBuilderByCriteria($criteria);

        return $query->getResult();
    }

    /**
     * @throws QueryException
     */
    private function queryBuilderByCriteria(Criteria $criteria): Query
    {
        return $this->entityManager()->createQueryBuilder()
            ->select('guarantor')
            ->from(User::class, 'user')
            ->addCriteria(DoctrineCriteriaMapper::create($criteria, DoctrineUserCriteriaFieldsMapper::create()))
            ->getQuery();
    }

}
