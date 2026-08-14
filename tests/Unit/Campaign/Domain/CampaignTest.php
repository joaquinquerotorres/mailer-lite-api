<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Events\CampaignCreatedEvent;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use Tests\TestCase;

final class CampaignTest extends TestCase
{
    public function test_it_should_return_valid_campaign(): void
    {
        $campaign = new Campaign(
            new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'),
            new CampaignNameValueObject('Spring launch'),
            new CampaignDateRangeValueObject(
                new \DateTimeImmutable('+10 days'),
                new \DateTimeImmutable('+20 days')
            )
        );

        $campaign->create();

        $events = $campaign->pullDomainEvents();

        $this->assertCount(1, $events);
        $this->assertInstanceOf(CampaignCreatedEvent::class, $events[0]);
        $this->assertSame('campaign.created', $events[0]->eventName());
        $this->assertSame('123e4567-e89b-12d3-a456-426614174000', $events[0]->campaignUuid());
    }
}
