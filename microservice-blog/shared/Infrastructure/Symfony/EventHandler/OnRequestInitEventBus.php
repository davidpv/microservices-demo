<?php


namespace Shared\Infrastructure\Symfony\EventHandler;

use Shared\Infrastructure\Bus\Event\EventBus;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Messenger\MessageBusInterface;

class OnRequestInitEventBus implements EventSubscriberInterface
{
    public function __construct(
        private MessageBusInterface $eventBus
    )
    {
    }

    public static function getSubscribedEvents(): iterable
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }

    public function onRequest(RequestEvent $event): void
    {
        //EventBus::setEventBus($this->eventBus);
    }
}
