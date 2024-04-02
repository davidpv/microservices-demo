<?php

declare(strict_types=1);

namespace App\Modules\User\Infrastructure\Request;

use Shared\Infrastructure\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CreateUserPostRequest extends BaseRequest
{

    #[Assert\NotNull]
    #[Assert\Uuid]
    protected $id;

    #[Assert\NotNull]
    protected $username;

    #[Assert\NotNull]
    #[Assert\Email]
    protected $email;

    #[Assert\NotNull]
    #[Assert\Callback([self::class, 'validateName'])]
    protected $firstName;

    #[Assert\NotNull]
    #[Assert\Callback([self::class, 'validateName'])]
    protected $lastName;

    public static function validateName(
        mixed $data,
        ExecutionContextInterface $context
    ): void {
        if (null === $data) {
            $context->buildViolation('firstname_required')->addViolation();
            return;
        }
        if (strlen($data) < 3) {
            $context->buildViolation('firstname_too_short')->addViolation();
        }
    }

}
