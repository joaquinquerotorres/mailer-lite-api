<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Infrastructure\Repository\CampaignEloquent;
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
}
