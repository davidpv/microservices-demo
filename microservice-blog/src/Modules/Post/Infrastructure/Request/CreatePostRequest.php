<?php

declare(strict_types=1);

namespace App\Modules\Post\Infrastructure\Request;

use Shared\Infrastructure\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePostRequest extends BaseRequest
{

    #[Assert\NotNull]
    #[Assert\Uuid]
    protected $id;

    #[Assert\NotNull]
    #[Assert\Uuid]
    protected $userId;

    #[Assert\NotNull]
    protected $title;

    #[Assert\NotNull]
    protected $content;


}