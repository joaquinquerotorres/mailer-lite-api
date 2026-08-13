<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Pagination\ValueObjects;

use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use PHPUnit\Framework\TestCase;

final class LimitValueObjectTest extends TestCase
{
    public function test_it_should_create_a_limit_value_object()
    {
        $limit = new LimitValueObject(10);

        $this->assertInstanceOf(LimitValueObject::class, $limit);
        $this->assertEquals(10, $limit->value());
    }
}