<?php

declare(strict_types=1);

namespace App\Shared\Instrastructure\Bus;

use App\Shared\Domain\Bus\Command;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Support\Facades\Bus;

final class LaravelCommandBus implements CommandBus
{
    public function dispatch(Command $command): void
    {
        Bus::dispatch($command);
    }
}
