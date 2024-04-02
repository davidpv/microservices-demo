<?php

namespace App\Modules\User\Infrastructure\Request;

use Shared\Infrastructure\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class ListUserGetRequest extends BaseRequest
{

    #[Assert\Positive]
    protected $limit;

    #[Assert\PositiveOrZero]
    protected $offset;

}
