<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\GetCampaign;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Campaign\Application\GetCampaign\GetCampaignQueryHandler;
use App\Campaign\Application\GetCampaign\GetCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class GetCampaignQueryHandlerTest extends TestCase
{
    public function test_it_should_return_a_get_campaign_query_handler()
    {
        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $name = 'Test Campaign';
        $startDate = new \DateTimeImmutable('+1 day');
        $endDate = new \DateTimeImmutable('+2 days');
        $query = new GetCampaignQuery(
            $uuid
        );
        
        $campaignDTO = new CampaignDTO($uuid, $name, $startDate, $endDate);
        $campaignRepository = $this->createMock(CampaignRepository::class);
        $campaignRepository->expects($this->once())->method('find')->with(new CampaignUuidValueObject($uuid))->willReturn($campaignDTO);
        $handler = new GetCampaignQueryHandler($campaignRepository);
        
        $result = $handler->__invoke($query);
        $this->assertEquals($campaignDTO, $result);
    }
}
