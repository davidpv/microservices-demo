<?php

namespace Shared\Infrastructure\Symfony\EventHandler;

use DateTimeInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class OnViewSerialize implements EventSubscriberInterface
{
    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => 'onKernelView',
        ];
    }

    public function onKernelView(ViewEvent $event): void
    {
        $result = $event->getControllerResult();
        if (!$result) {
            $event->setResponse(new JsonResponse());

            return;
        }

        $response = $this->createResponseFromResult($result);
        $event->setResponse($response);
    }

    private function createDateCallback(): callable
    {
        return function (object $innerObject, object $outerObject, string $attributeName, string $format = null, array $context = []): string {
            return $innerObject instanceof \DateTime ? $innerObject->format(DateTimeInterface::ATOM) : '';
        };
    }

    private function createResponseFromResult($result): Response
    {
        $defaultContext = [
            AbstractNormalizer::CALLBACKS => [
                'createdAt' => $this->createDateCallback(),
            ],
        ];

        return new Response(
            $this->serializer->serialize($result, 'json', $defaultContext),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
