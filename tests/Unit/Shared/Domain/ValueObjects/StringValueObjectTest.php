<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\StringValueObject;
use Tests\TestCase;

final class StringValueObjectTest extends TestCase
{
    public function test_it_should_return_valid_stringValueObject(): void
    {
        $value = 'Valid String';
        $stringValueObject = new class($value) extends StringValueObject {};

        $this->assertSame($value, $stringValueObject->value());
    }
}