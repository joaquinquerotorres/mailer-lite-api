<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use Tests\TestCase;

final class CampaignUuidValueObjectTest extends TestCase
{
    public function test_it_should_return_valid_campaignUuidValueObject(): void
    {
        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $campaignUuidValueObject = new CampaignUuidValueObject($uuid);

        $this->assertSame($uuid, $campaignUuidValueObject->value());
    }

    public function test_it_should_return_invalid_campaignUuidValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Invalid UUID format.');

        new CampaignUuidValueObject('invalid-uuid');
    }
}