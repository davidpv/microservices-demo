<?php

namespace Shared\Infrastructure\Request;

interface RequestInterface
{
    public function dataRequest(): array;

    public function data(): array;

    public function routeParams(): array;

    public function filters(): array;

    public function locale(): string;

    public function files(): array;

    public function getHost(): string;
}