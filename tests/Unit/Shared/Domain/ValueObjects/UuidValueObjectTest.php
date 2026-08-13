<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\UuidValueObject;
use Tests\TestCase;

final class UuidValueObjectTest extends TestCase
{
    public function text_it_should_return_valid_uuidValueObject(): void
    {
        $value = '550e8400-e29b-41d4-a716-446655440000';
        $uuidValueObject = new class($value) extends UuidValueObject {};

        $this->assertSame($value, $uuidValueObject->value());
    }

    public function test_it_should_return_invalid_uuidValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Invalid UUID format.');

        new class('invalid-uuid') extends UuidValueObject {};
    }
}