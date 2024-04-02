<?php

namespace App\Modules\User\Domain;


use Shared\Domain\Aggregate\AggregateRoot;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Domain\ValueObject\UuidValueObject;

final class User extends AggregateRoot
{

    public DateTimeValueObject $createdAt;

    public function __construct(
        public readonly UuidValueObject $id,
        public readonly UserUserName $username,
        public readonly UserEmail $email,
        public readonly UserFirstName $firstName,
        public readonly UserLastName $lastName,
        private UserEnabled $enabled
    ) {
        $this->createdAt = DateTimeValueObject::now();
    }

    public function enableUser(): void
    {
        $this->enabled = UserEnabled::create(true);
        $this->record(UserEnabledEvent::from($this));
    }

    public function disableUser(): void
    {
        $this->enabled = UserEnabled::create(false);
        $this->record(UserDisabledEvent::from($this));
    }

    public static function create(
        string $id,
        string $username,
        string $email,
        string $firstName,
        string $lastName,
        bool $enabled
    ): self {
        $user = new self(
            UuidValueObject::fromString($id),
            UserUserName::create($username),
            UserEmail::create($email),
            UserFirstName::create($firstName),
            UserLastName::create($lastName),
            UserEnabled::create($enabled)
        );

        $user->record(UserCreatedEvent::from($user));

        return $user;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled->value();
    }

    public function getFullName(): string
    {
        return $this->firstName->value().' '.$this->lastName->value();
    }


}
