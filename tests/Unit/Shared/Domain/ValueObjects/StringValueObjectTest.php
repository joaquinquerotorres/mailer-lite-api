<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\StringValueObject;

final class StringValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValidStringValueObject(): void
    {
        $value = 'Valid String';
        $stringValueObject = new class($value) extends StringValueObject {};

        $this->assertSame($value, $stringValueObject->value());
    }
}