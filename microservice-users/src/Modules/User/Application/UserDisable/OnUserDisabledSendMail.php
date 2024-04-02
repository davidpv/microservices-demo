<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserDisable;

use App\Modules\User\Domain\UserDisabledEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
final readonly class OnUserDisabledSendMail
{

    public function __construct(public MessageBusInterface $bus)
    {
    }

    public function __invoke(UserDisabledEvent $event): void
    {
        $data = $event->to();
        $message = new SendMailUserDisabledMessage(
            "Your account has been disabled",
            "no-reply@example.com",
            "{$data['email']},admin@admin.com",
            "Hello {$data['username']}, your account has been disabled."
        );
//        $this->bus->dispatch($message, [new AmqpStamp('send_mail')]);
    }
}
