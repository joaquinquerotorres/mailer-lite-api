<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use Tests\TestCase;

final class CampaignDateRangeValueObjectTest extends TestCase
{
    public function test_it_should_return_valid_campaignDateRangeValueObject(): void
    {
        $startDate = new \DateTimeImmutable('+10 days');
        $endDate = new \DateTimeImmutable('+20 days');

        $campaignDateRangeValueObject = new CampaignDateRangeValueObject($startDate, $endDate);

        $this->assertSame($startDate, $campaignDateRangeValueObject->startDate());
        $this->assertSame($endDate, $campaignDateRangeValueObject->endDate());
    }

    public function test_it_should_return_invalid_campaignDateRangeValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Start date must be before end date.');

        $startDate = new \DateTimeImmutable('+20 days');
        $endDate = new \DateTimeImmutable('+10 days');

        new CampaignDateRangeValueObject($startDate, $endDate);
    }

    public function test_it_should_return_campaignDateRangeValueObjectWithPastDates(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign start date cannot be in the past.');

        $startDate = new \DateTimeImmutable('now');
        $startDate = $startDate->modify('-5 days');
        $endDate = new \DateTimeImmutable('now');

        new CampaignDateRangeValueObject($startDate, $endDate);
    }

}