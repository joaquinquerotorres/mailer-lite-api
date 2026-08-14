<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bus;

use App\Shared\Instrastructure\Bus\LaravelCommandBus;
use Tests\TestCase;

final class LaravelCommandBusTest extends TestCase
{
    public function test_it_should_return_a_command_bus()
    {
        $commandBus = new LaravelCommandBus();
        $this->assertInstanceOf(LaravelCommandBus::class, $commandBus);
    }
}