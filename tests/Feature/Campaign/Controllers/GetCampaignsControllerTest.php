<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use App\Http\Resources\CampaignResource;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetCampaignsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_all_campaigns(): void
    {
        CampaignEloquent::factory()
            ->count(15)
            ->sequence(fn (Sequence $sequence) => [
                'created_at' => now()->subSeconds($sequence->index),
            ])
            ->create();

        $paginator = CampaignEloquent::query()
            ->orderBy('created_at', 'desc')
            ->cursorPaginate(10);

        $response = $this->getJson('/api/campaigns?limit=10');

        $response->assertOk();
        $response->assertJsonPath('nextCursor', $paginator->nextCursor()?->encode());
        $response->assertJsonPath('prevCursor', $paginator->previousCursor()?->encode());
    }

    public function test_it_should_return_a_campaign(): void
    {
        $campaignEloquent = CampaignEloquent::factory()->create();

        $campaign = new Campaign(
            new CampaignUuidValueObject($campaignEloquent->uuid),
            new CampaignNameValueObject($campaignEloquent->name),
            new CampaignDateRangeValueObject($campaignEloquent->start_date->toDateTimeImmutable(), $campaignEloquent->end_date->toDateTimeImmutable())
        );
        $campaignResource = new CampaignResource($campaign);

        $response = $this->getJson('/api/campaigns/'.$campaignEloquent->uuid);
        $response->assertOk();
        $response->assertJson($campaignResource->resolve());
    }

    public function test_it_should_return_a_404_if_the_campaign_is_not_found(): void
    {
        $response = $this->getJson('/api/campaigns/123e4567-e89b-12d3-a456-426614174000');
        $response->assertNotFound();
    }
}
