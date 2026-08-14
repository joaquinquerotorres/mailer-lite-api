<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\IntValueObject;
use Illuminate\Validation\Rules\In;
use PHPUnit\Framework\TestCase;

final class IntValueObjectTest extends TestCase
{
    public function test_it_should_return_a_int_value_object()
    {
        $value = 1;
        $intValueObject = new class($value) extends IntValueObject {};
        $this->assertEquals(1, $intValueObject->value());
    }
}