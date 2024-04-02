<?php
declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

interface QueryBus
{
    public function handle(Query $query): mixed;
}
