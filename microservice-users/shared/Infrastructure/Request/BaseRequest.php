<?php

namespace Shared\Infrastructure\Request;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;


abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    protected function populate(): void
    {
        if ('' !== $this->getRequest()->getContent()) {
            $this->extract($this->getRequest()->toArray());
        }
        if (count($this->getRequest()->query->all()) > 0) {
            $this->extract($this->getRequest()->query->all());
        }
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    public function validate(): void
    {
        $errors = $this->validator->validate($this);

        if ($errors->count() > 0) {
            $messages = [
                'message' => 'validation_failed',
                'errors' => [],
            ];

            foreach ($errors as $message) {
                $messages['errors'][$message->getPropertyPath()]
                    = $message->getMessage();
            }

            $response = new JsonResponse($messages, Response::HTTP_BAD_REQUEST);
            $response->send();

            exit;
        }

    }

    public function get(string $property)
    {
        if ($this->requestBodyIsEmpty()) {
            return $this->getRequest()->query->get($property);
        }

        if (key_exists($property, $this->getRequest()->toArray())) {
            return $this->getRequest()->toArray()[$property];
        }

        return null;
    }

    public function requestBodyIsEmpty(): bool
    {
        return '' === $this->getRequest()->getContent();
    }

    protected function extract(array $params): void
    {
        foreach ($params as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
