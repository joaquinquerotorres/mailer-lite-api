<?php

declare(strict_types=1);

namespace App\Shared\Instrastructure\Bus;

use App\Shared\Domain\Bus\Query;
use App\Shared\Domain\Bus\QueryBus;
use Illuminate\Support\Facades\Bus;

final class LaravelQueryBus implements QueryBus
{
    public function ask(Query $query): mixed
    {
        return Bus::dispatchSync($query);
    }
}
