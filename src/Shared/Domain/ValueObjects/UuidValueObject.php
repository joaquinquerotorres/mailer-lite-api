<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObjects;

abstract class UuidValueObject
{
    public function __construct(protected string $value) 
    {
        $this->validate($value);
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (!preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $value)) {
            throw new \InvalidArgumentException('Invalid UUID format.');
        }
    }
}