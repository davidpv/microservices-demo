<?php

declare(strict_types=1);

namespace App\Modules\Post\Infrastructure\Repositories;

use App\Modules\Post\Domain\Post;
use App\Modules\Post\Domain\PostRepository;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;


class DoctrinePostRepository extends DoctrineRepository implements PostRepository
{
    public function getAll()
    {
        return $this->entityManager()->createQueryBuilder()
            ->select('post')
            ->from(Post::class, 'post')
            ->getQuery()->getResult();
    }

    public function getOneById(UuidValueObject $id): ?Post
    {
        return $this->entityManager()->createQueryBuilder()
            ->select('post')
            ->from(Post::class, 'post')
            ->where('post.id = :id')
            ->setParameter('id', $id->value())
            ->getQuery()->getOneOrNullResult();
    }


}