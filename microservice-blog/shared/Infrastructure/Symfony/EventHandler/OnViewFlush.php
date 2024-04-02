<?php


namespace Shared\Infrastructure\Symfony\EventHandler;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class OnViewFlush implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'onView'
        ];
    }

    public function onView(): void
    {
        $this->entityManager->flush();
    }
}
