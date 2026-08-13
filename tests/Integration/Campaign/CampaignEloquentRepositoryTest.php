<?php

declare(strict_types=1);

namespace App\Tests\Integration\Campaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use App\Campaign\Infrastructure\Repository\CampaignEloquentRepository;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CampaignEloquentRepositoryTest extends TestCase
{
     use RefreshDatabase;

    public function test_it_should_return_all_campaigns(): void
    {
        $campaignsEloquentCreated = CampaignEloquent::factory()->count(10)->create();

        $campaignsDomain = [];
        foreach ($campaignsEloquentCreated as $campaignEloquent) {
            $campaignsDomain[] = new Campaign(
                new CampaignUuidValueObject($campaignEloquent->uuid),
                new CampaignNameValueObject($campaignEloquent->name),
                new CampaignDateRangeValueObject($campaignEloquent->start_date->toDateTimeImmutable(), $campaignEloquent->end_date->toDateTimeImmutable())
            );
        }

        $campaignRepository = new CampaignEloquentRepository();
        $cursorPaginationResult = $campaignRepository->paginate(new CursorValueObject(''), new LimitValueObject(10));

        $this->assertEquals($campaignsDomain, $cursorPaginationResult->items);
    }
}
    