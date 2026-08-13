<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class CampaignUuidValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValidCampaignUuidValueObject(): void
    {
        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $campaignUuidValueObject = new CampaignUuidValueObject($uuid);

        $this->assertSame($uuid, $campaignUuidValueObject->value());
    }

    public function testInvalidCampaignUuidValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Invalid UUID format.');

        new CampaignUuidValueObject('invalid-uuid');
    }
}