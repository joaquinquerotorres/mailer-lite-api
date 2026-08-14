<?php

declare(strict_types=1);

namespace Tests\Unit\Campaign\Application\GetCampaigns;

use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use App\Campaign\Application\GetCampaigns\GetCampaignsQueryHandler;
use App\Campaign\Application\GetCampaigns\GetCampaignsUseCase;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use PHPUnit\Framework\TestCase;

final class GetCampaignsQueryHandlerTest extends TestCase
{
    public function test_it_should_invoke_the_get_campaigns_query_handler()
    {
        $query = new GetCampaignsQuery('123', 10);
        $cursor = new CursorValueObject('123');
        $limit = new LimitValueObject(10);
        $getCampaignsUseCase = $this->createMock(GetCampaignsUseCase::class);
        $getCampaignsUseCase->expects($this->once())->method('__invoke')->with($cursor, $limit)->willReturn(new CursorPagination([], null, null));
        $handler = new GetCampaignsQueryHandler($getCampaignsUseCase);

        $result = $handler->__invoke($query);

        $this->assertInstanceOf(CursorPagination::class, $result);
    }
}
