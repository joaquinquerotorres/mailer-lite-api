<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application;

use App\Campaign\Application\GetCampaignsUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Infrastructure\Repository\CampaignEloquentRepository;
use App\Shared\Domain\Pagination\CursorPagination;
use Tests\TestCase;

final class GetCampaignsUseCaseTest extends TestCase
{
    public function test_it_should_return_all_campaigns(): void
    {
        $campaigns = [
            new Campaign(
                new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'),
                new CampaignNameValueObject('Spring launch'),
                new CampaignDateRangeValueObject(
                    new \DateTimeImmutable('+10 days'),
                    new \DateTimeImmutable('+20 days')
                )
            ),
        ];

        $cursorPagination = new CursorPagination(
            $campaigns,
            'next_cursor',
            'previous_cursor'
        );
        $campaignRepository = $this->createMock(CampaignEloquentRepository::class);
        $campaignRepository->method('paginate')->willReturn($cursorPagination);

        $useCase = new GetCampaignsUseCase($campaignRepository);

        /** @var CursorPagination $result */
        $result = $useCase('', 100);

        $this->assertEquals($cursorPagination, $result);
        $this->assertEquals('next_cursor', $result->nextCursor);
        $this->assertEquals('previous_cursor', $result->prevCursor);
    }
}
