<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;

final class CampaignNameValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValidCampaignName(): void
    {
        $name = 'Valid Campaign Name';
        $campaignName = new CampaignNameValueObject($name);

        $this->assertSame($name, $campaignName->value());
    }

    public function testEmptyCampaignName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign name cannot be empty.');

        new CampaignNameValueObject('');
    }

    public function testExceedingMaxLengthCampaignName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign name cannot exceed 100 characters.');

        new CampaignNameValueObject(str_repeat('a', 101));
    }
}