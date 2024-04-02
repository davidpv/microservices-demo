<?php
declare(strict_types=1);
namespace Shared\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

final class EntityExist extends Constraint
{
    public string $message = "Entity '{{ entity }}' with property '{{ property }}': '{{ value }}' does not exist.";

    public function __construct(
        public string $entity = '',
        public string $property = 'id',
        public ?string $messageOverride = null
    ) {
        if (null !== $messageOverride) {
            $this->message = $messageOverride;
        }
        parent::__construct(payload: []);
    }
}