<?php declare(strict_types=1);

namespace App\Modules\Event\Domain;

interface EventRepository
{

    public function save(Event $event): void;

}
