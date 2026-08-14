<?php

declare(strict_types=1);

namespace App\Tests\Integration\Bus;

use App\Shared\Instrastructure\Bus\LaravelQueryBus;
use Tests\TestCase;

final class LaravelQueryBusTest extends TestCase
{
    public function test_it_should_return_a_query_bus()
    {
        $queryBus = new LaravelQueryBus();
        $this->assertInstanceOf(LaravelQueryBus::class, $queryBus);
    }
}