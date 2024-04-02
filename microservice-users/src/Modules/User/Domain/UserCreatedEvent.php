<?php declare(strict_types=1);

namespace App\Modules\User\Domain;

use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\ValueObject\UuidValueObject;

final class UserCreatedEvent extends DomainEvent
{

    public function __construct(
        UuidValueObject $aggregate,
        private readonly string  $username,
        private readonly string  $firstName,
        private readonly string  $lastName,
        private readonly string  $email
    )
    {
        $aggregateString = $aggregate->__toString();
        parent::__construct($aggregateString);
    }

    public static function from(User|AggregateRoot $aggregate): self
    {
        return new self(
            $aggregate->id,
            $aggregate->username->value(),
            $aggregate->firstName->value(),
            $aggregate->lastName->value(),
            $aggregate->email->getFullAddress()
        );
    }

    public static function eventName(): string
    {
        return 'user.created';
    }

    public function to(): array
    {
        return [
            'username' => $this->username,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email
        ];
    }
}
