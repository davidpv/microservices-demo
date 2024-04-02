<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\ValueObject\UuidValueObject;

class UserDisabledEvent extends DomainEvent
{

    public function __construct(
        UuidValueObject $aggregate,
        private readonly string  $username,
        private readonly string  $firstName,
        private readonly string  $lastName,
        private readonly string  $email
    )
    {
        parent::__construct($aggregate->value());
    }

    public static function from(User|AggregateRoot $aggregate): DomainEvent
    {
        return new self(
            $aggregate->id,
            $aggregate->username->value(),
            $aggregate->firstName->value(),
            $aggregate->lastName->value(),
            $aggregate->email->value()
        );
    }

    public static function eventName(): string
    {
        return 'user.disabled';
    }

    public function to(): array
    {
        return [
            'id' => $this->aggregateId(),
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email
        ];
    }
}
