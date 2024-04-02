<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Domain\Criteria\Criteria;

readonly class ListUsersCriteria extends Criteria
{

    public function getAllowedFields(): array
    {
        return [
            'username',
            'email'
        ];
    }
}
