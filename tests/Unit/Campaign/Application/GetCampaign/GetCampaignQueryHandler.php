<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\GetCampaign;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Campaign\Application\GetCampaign\GetCampaignQueryHandler;
use App\Campaign\Application\GetCampaign\GetCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class GetCampaignQueryHandlerTest extends TestCase
{
    public function test_it_should_return_a_get_campaign_query_handler()
    {
        $campaign = new Campaign(
            new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'),
            new CampaignNameValueObject('Spring launch'),
            new CampaignDateRangeValueObject(
                new \DateTimeImmutable('+10 days'),
                new \DateTimeImmutable('+20 days')
            )
        );
        $query = new GetCampaignQuery(new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'));
        $useCase = $this->createMock(GetCampaignUseCase::class);
        $useCase->method('__invoke')->willReturn($campaign);

        $handler = new GetCampaignQueryHandler($useCase);
        $result = $handler->__invoke($query);
        $this->assertEquals($campaign, $result);
    }
}