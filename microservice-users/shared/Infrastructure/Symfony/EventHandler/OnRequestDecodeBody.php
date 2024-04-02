<?php

namespace Shared\Infrastructure\Symfony\EventHandler;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

#[AsEventListener(event: 'onRequest', method: 'onRequest', priority: -10)]
class OnRequestDecodeBody implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): iterable
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }

    public function onRequest(RequestEvent $event) : void
    {
        $request = $event->getRequest();
        $contentType = $request->headers->get('Content-Type');
        if (str_starts_with($contentType, 'application/json')) {
            $data = json_decode($request->getContent(), true);
            $request->request->replace(is_array($data) ? $data : []);
        }
    }

//    public function __invoke(RequestEvent $event): void
//    {
//        $request = $event->getRequest();
//        $contentType = $request->headers->get('Content-Type');
//        if (str_starts_with($contentType, 'application/json')) {
//            $data = json_decode($request->getContent(), true);
//            $request->request->replace(is_array($data) ? $data : []);
//        }
//    }
}
