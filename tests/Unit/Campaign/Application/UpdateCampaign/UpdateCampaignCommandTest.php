<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\UpdateCampaign;

use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommand;
use PHPUnit\Framework\TestCase;

final class UpdateCampaignCommandTest extends TestCase
{
    public function test_it_should_return_a_update_campaign_command()
    {
        $campaignUuid = '123e4567-e89b-12d3-a456-426614174000';
        $name = 'Test Campaign';
        $startDate = new \DateTimeImmutable('+1 day');
        $endDate = new \DateTimeImmutable('+2 days');
        
        $command = new UpdateCampaignCommand($campaignUuid, $name, $startDate, $endDate);
        
        $this->assertEquals($campaignUuid, $command->campaignUuid());
        $this->assertEquals($name, $command->name());
        $this->assertEquals($startDate, $command->startDate());
        $this->assertEquals($endDate, $command->endDate());
    }
}