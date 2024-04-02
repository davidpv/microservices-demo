<?php

declare(strict_types=1);

namespace Api\Shared\Tools;

function jsonDecode(string|bool $string): array|null
{
    if (is_bool($string)) {
        return null;
    }

    if (isJson($string)) {
        return \json_decode($string, true, 512, JSON_THROW_ON_ERROR);
    }

    return null;
}

function jsonEncode(array $array): string|false
{
    return \json_encode($array, 512, JSON_THROW_ON_ERROR);
}

function isJson(string $string): bool
{
    \json_decode($string, true);

    return JSON_ERROR_NONE === \json_last_error();
}
