<?php

declare(strict_types=1);

namespace App\Campaign\Domain\ValueObjects;

use App\Shared\Domain\ValueObjects\StringValueObject;

final class CampaignNameValueObject extends StringValueObject
{
    private const MAX_LENGTH = 100;

    public function __construct(string $value)
    {
        $this->validate($value);
        parent::__construct($value);
    }

    private function validate(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Campaign name cannot be empty.');
        }

        if (strlen($value) > self::MAX_LENGTH) {
            throw new \InvalidArgumentException('Campaign name cannot exceed ' . self::MAX_LENGTH . ' characters.');
        }
    }
}

