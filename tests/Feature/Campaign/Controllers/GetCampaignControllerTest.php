<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Infrastructure\Controllers\GetCampaignController;
use App\Shared\Domain\Bus\QueryBus;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

final class GetCampaignControllerTest extends TestCase
{
    public function test_it_should_return_a_campaign(): void
    {
        $campaignUuid = '123e4567-e89b-12d3-a456-426614174000';
        $name = 'Test Campaign';
        $startDate = new \DateTimeImmutable('+1 day');
        $endDate = new \DateTimeImmutable('+2 days');
        $campaignDTO = new CampaignDTO($campaignUuid, $name, $startDate, $endDate);

        $queryBus = $this->createMock(QueryBus::class);
        $queryBus->expects($this->once())->method('ask')->with(new GetCampaignQuery($campaignUuid))->willReturn($campaignDTO);
        $controller = new GetCampaignController($queryBus);

        $response = $controller->__invoke($campaignUuid);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals(
            json_encode([
                'id' => $campaignUuid,
                'name' => $name,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
            ]),
            $response->getContent()
        );
    }
}
