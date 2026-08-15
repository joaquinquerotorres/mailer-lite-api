<?php

declare(strict_types=1);

namespace Tests\Unit\Campaign\Application\SendCampaign;

use App\Campaign\Application\SendCampaign\SendCampaignCommand;
use Tests\TestCase;

final class SendCampaingCommanTest extends TestCase
{
    public function test_it_should_invoke_the_send_campaign_command()
    {
        $command = new SendCampaignCommand('123e4567-e89b-12d3-a456-426614174000');
        $this->assertInstanceOf(SendCampaignCommand::class, $command);
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', $command->campaignUuid());
    }
}
