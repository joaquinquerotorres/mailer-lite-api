<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use Tests\TestCase;

final class CampaignNameValueObjectTest extends TestCase
{
    public function test_it_should_return_valid_campaignName(): void
    {
        $name = 'Valid Campaign Name';
        $campaignName = new CampaignNameValueObject($name);

        $this->assertSame($name, $campaignName->value());
    }

    public function test_it_should_return_empty_campaignName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign name cannot be empty.');

        new CampaignNameValueObject('');
    }

    public function test_it_should_return_exceeding_max_length_campaignName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign name cannot exceed 100 characters.');

        new CampaignNameValueObject(str_repeat('a', 101));
    }
}