<?php

declare(strict_types=1);

namespace App\Modules\User\Application\UserDisable;

readonly class SendMailUserDisabledMessage
{

    public function __construct(
        public string $subject,
        public string $sender,
        public string $recipients,
        public string $body
    )
    {
    }

}