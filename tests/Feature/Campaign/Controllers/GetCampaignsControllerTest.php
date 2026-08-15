<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use App\Http\Resources\CampaignResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class GetCampaignsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_return_all_campaigns(): void
    {
        CampaignEloquent::factory()->count(15)->create();

        $paginator = CampaignEloquent::query()
            ->orderBy('uuid', 'desc')
            ->cursorPaginate(10);

        $items = [];
        foreach ($paginator->items() as $model) {
            $items[] = new CampaignDTO(
                $model->uuid,
                $model->name,
                $model->start_date->toDateTimeImmutable(),
                $model->end_date->toDateTimeImmutable()
            );
        }

        $response = $this->getJson('/api/campaigns?limit=10');

        $response->assertOk();
        $response->assertJsonPath('items', CampaignResource::collection($items)->resolve());
        $response->assertJsonPath('nextCursor', $paginator->nextCursor()?->encode());
        $response->assertJsonPath('prevCursor', $paginator->previousCursor()?->encode());
    }
}
