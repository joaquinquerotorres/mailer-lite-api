<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\UuidValueObject;

final class UuidValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValidUuidValueObject(): void
    {
        $value = '550e8400-e29b-41d4-a716-446655440000';
        $uuidValueObject = new class($value) extends UuidValueObject {};

        $this->assertSame($value, $uuidValueObject->value());
    }

    public function testInvalidUuidValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Invalid UUID format.');

        new class('invalid-uuid') extends UuidValueObject {};
    }
}