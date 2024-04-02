<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Doctrine;

use Shared\Domain\Criteria\CriteriaFieldsMapper;
use Shared\Domain\Criteria\MysqlCriteriaFieldsMapperRepository;

final class DoctrineUserCriteriaFieldsMapper extends MysqlCriteriaFieldsMapperRepository implements CriteriaFieldsMapper
{

    public static function create(): CriteriaFieldsMapper
    {
        return new self();
    }
}
