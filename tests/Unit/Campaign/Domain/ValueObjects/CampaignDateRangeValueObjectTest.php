<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Domain\ValueObjects;

use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;

final class CampaignDateRangeValueObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testValidCampaignDateRangeValueObject(): void
    {
        $startDate = new \DateTimeImmutable('+10 days');
        $endDate = new \DateTimeImmutable('+20 days');

        $campaignDateRangeValueObject = new CampaignDateRangeValueObject($startDate, $endDate);

        $this->assertSame($startDate, $campaignDateRangeValueObject->startDate());
        $this->assertSame($endDate, $campaignDateRangeValueObject->endDate());
    }

    public function testInvalidCampaignDateRangeValueObject(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Start date must be before end date.');

        $startDate = new \DateTimeImmutable('+20 days');
        $endDate = new \DateTimeImmutable('+10 days');

        new CampaignDateRangeValueObject($startDate, $endDate);
    }

    public function testCampaignDateRangeValueObjectWithPastDates(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageIsOrContains('Campaign start date cannot be in the past.');

        $startDate = new \DateTimeImmutable('now');
        $startDate = $startDate->modify('-5 days');
        $endDate = new \DateTimeImmutable('now');

        new CampaignDateRangeValueObject($startDate, $endDate);
    }

}