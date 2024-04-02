<?php

declare(strict_types=1);

namespace App\Modules\Event\Infrastructure\Repositories;

use App\Modules\Event\Domain\EventRepository;
use Shared\Infrastructure\Persistence\Doctrine\DoctrineRepository;

class DoctrineEventRepository extends DoctrineRepository implements EventRepository
{


}