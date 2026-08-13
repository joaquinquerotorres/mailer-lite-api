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
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

        $campaignRepository = new CampaignEloquentRepository;
        $cursorPaginationResult = $campaignRepository->paginate(new CursorValueObject(''), new LimitValueObject(10));

        $this->assertEquals($campaignsDomain, $cursorPaginationResult->items);
    }

    public function test_it_should_return_a_campaign(): void
    {
        $campaignEloquent = CampaignEloquent::factory()->create();
        $campaign = new Campaign(
            new CampaignUuidValueObject($campaignEloquent->uuid),
            new CampaignNameValueObject($campaignEloquent->name),
            new CampaignDateRangeValueObject($campaignEloquent->start_date->toDateTimeImmutable(), $campaignEloquent->end_date->toDateTimeImmutable())
        );
        $campaignRepository = new CampaignEloquentRepository;
        $campaignResult = $campaignRepository->find(new CampaignUuidValueObject($campaignEloquent->uuid));
        $this->assertEquals($campaign, $campaignResult);
    }

    public function test_it_should_return_a_404_if_the_campaign_is_not_found(): void
    {
        $campaignRepository = new CampaignEloquentRepository;
        $this->expectException(NotFoundHttpException::class);
        $campaignRepository->find(new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'));
    }

    public function test_it_should_map_non_carbon_dates_to_domain(): void
    {
        $campaignEloquent = CampaignEloquent::factory()->create();
        $campaignEloquent->mergeCasts([
            'start_date' => 'string',
            'end_date' => 'string',
        ]);

        $this->assertIsString($campaignEloquent->start_date);
        $this->assertIsString($campaignEloquent->end_date);

        $campaign = new Campaign(
            new CampaignUuidValueObject($campaignEloquent->uuid),
            new CampaignNameValueObject($campaignEloquent->name),
            new CampaignDateRangeValueObject(
                new \DateTimeImmutable($campaignEloquent->start_date),
                new \DateTimeImmutable($campaignEloquent->end_date)
            )
        );

        $campaignRepository = new CampaignEloquentRepository;
        $mapToDomain = new \ReflectionMethod($campaignRepository, 'mapToDomain');
        $campaignResult = $mapToDomain->invoke($campaignRepository, $campaignEloquent);

        $this->assertEquals($campaign, $campaignResult);
    }
}
