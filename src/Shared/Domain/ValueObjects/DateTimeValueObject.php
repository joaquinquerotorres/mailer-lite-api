<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

abstract class DateTimeValueObject
{
    public function __construct(protected \DateTimeImmutable $value)
    {
    }

    public function value(): \DateTimeImmutable
    {
        return $this->value;
    }
}