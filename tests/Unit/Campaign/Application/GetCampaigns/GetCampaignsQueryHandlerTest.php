<?php

declare(strict_types=1);

namespace Tests\Unit\Campaign\Application\GetCampaigns;

use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use App\Campaign\Application\GetCampaigns\GetCampaignsQueryHandler;
use App\Campaign\Application\GetCampaigns\GetCampaignsUseCase;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Infrastructure\Repository\CampaignEloquentRepository;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use PHPUnit\Framework\TestCase;

final class GetCampaignsQueryHandlerTest extends TestCase
{
    public function test_it_should_invoke_the_get_campaigns_query_handler()
    {
        $campaigns = [
            new CampaignDTO(
                '123e4567-e89b-12d3-a456-426614174000',
                'Spring launch',
                new \DateTimeImmutable('+10 days'),
                new \DateTimeImmutable('+20 days')
            ),
        ];

        $cursorPagination = new CursorPagination(
            $campaigns,
            'next_cursor',
            'previous_cursor'
        );
        $campaignRepository = $this->createMock(CampaignEloquentRepository::class);
        $campaignRepository->method('paginate')->willReturn($cursorPagination);

        $query = new GetCampaignsQuery('123', 10);
        $handler = new GetCampaignsQueryHandler($campaignRepository);

        $result = $handler->__invoke($query);

        $this->assertInstanceOf(CursorPagination::class, $result);
        $this->assertEquals($cursorPagination, $result);
    }
}
