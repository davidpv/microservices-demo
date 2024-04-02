<?php

namespace App\Modules\User\Infrastructure\Request;

use Shared\Infrastructure\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class DisableUserPatchRequest extends BaseRequest
{
    #[Assert\NotNull]
    #[Assert\Uuid]
    protected $userId;

}