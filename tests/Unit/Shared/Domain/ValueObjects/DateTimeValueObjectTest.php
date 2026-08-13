<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\DateTimeValueObject;

final class DateTimeValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValue(): void
    {
        $dateTime = new class(new \DateTimeImmutable('2024-01-01 00:00:00')) extends DateTimeValueObject {
        };

        $this->assertEquals(new \DateTimeImmutable('2024-01-01 00:00:00'), $dateTime->value());
    }
}