<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Query;

use RuntimeException;

final class MessengerQueryNotRegisteredError extends RuntimeException
{
    public function __construct(Query $query)
    {
        $queryClass = get_class($query);

        parent::__construct("The query <$queryClass> hasn't a query handler associated");
    }
}
