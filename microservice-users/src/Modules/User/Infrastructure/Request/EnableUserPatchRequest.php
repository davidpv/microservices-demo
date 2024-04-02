<?php

namespace App\Modules\User\Infrastructure\Request;

use Shared\Infrastructure\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class EnableUserPatchRequest extends BaseRequest
{
    #[Assert\NotNull]
    #[Assert\Uuid]
    protected $userId;

}