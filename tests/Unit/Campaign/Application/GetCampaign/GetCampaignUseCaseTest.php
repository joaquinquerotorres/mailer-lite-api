<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\GetCampaign;

use App\Campaign\Application\GetCampaign\GetCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class GetCampaignUseCaseTest extends TestCase
{
    public function test_it_should_return_a_campaign()
    {

        $campaignUuid = new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000');
        $name = new CampaignNameValueObject('Test Campaign');
        $startDate = new \DateTimeImmutable('+1 day');
        $endDate = new \DateTimeImmutable('+2 days');
        $dateRange = new CampaignDateRangeValueObject($startDate, $endDate);
        $campaign = new Campaign($campaignUuid, $name, $dateRange);
        $campaignRepository = $this->createMock(CampaignRepository::class);
        $campaignRepository->expects($this->once())->method('find')->with($campaignUuid)->willReturn($campaign);
        $useCase = new GetCampaignUseCase($campaignRepository);
        
        $campaign = $useCase->__invoke(new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'));
        
        $this->assertEquals($campaignUuid->value(), $campaign->uuid()->value());
        $this->assertEquals($name->value(), $campaign->name()->value());
        $this->assertEquals($startDate->format('Y-m-d'), $campaign->dateRange()->startDate()->format('Y-m-d'));
        $this->assertEquals($endDate->format('Y-m-d'), $campaign->dateRange()->endDate()->format('Y-m-d'));
        $this->assertInstanceOf(Campaign::class, $campaign);
    }
}