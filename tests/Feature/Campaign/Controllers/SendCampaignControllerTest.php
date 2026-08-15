<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Application\SendCampaign\SendCampaignCommand;
use App\Campaign\Infrastructure\Repository\CampaignEloquent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

final class SendCampaignControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_should_send_a_campaign(): void
    {
        Bus::fake();

        $campaign = CampaignEloquent::factory()->create();

        $response = $this->postJson('/api/campaigns/'.$campaign->uuid.'/send');

        $response->assertAccepted();
        $response->assertJson(['message' => 'Campaign sent successfully']);

        Bus::assertDispatched(
            SendCampaignCommand::class,
            fn (SendCampaignCommand $command): bool => $command->campaignUuid() === $campaign->uuid
        );
    }
}
