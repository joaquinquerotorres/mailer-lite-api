<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain\Pagination\ValueObjects;

use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use PHPUnit\Framework\TestCase;

final class CursorValueObjectTest extends TestCase
{
    public function test_it_should_create_a_cursor_value_object()
    {
        $cursor = new CursorValueObject('123');

        $this->assertInstanceOf(CursorValueObject::class, $cursor);
        $this->assertEquals('123', $cursor->value());
    }
}