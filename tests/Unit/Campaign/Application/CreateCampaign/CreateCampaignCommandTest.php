<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\CreateCampaign;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use PHPUnit\Framework\TestCase;

final class CreateCampaignCommandTest extends TestCase
{
    public function test_it_should_return_a_create_campaign_command()
    {
        $command = new CreateCampaignCommand('123e4567-e89b-12d3-a456-426614174000', 'Test Campaign', new \DateTimeImmutable('2026-01-01'), new \DateTimeImmutable('2026-01-01'));
        $this->assertInstanceOf(CreateCampaignCommand::class, $command);
        $this->assertEquals('123e4567-e89b-12d3-a456-426614174000', $command->uuid());
        $this->assertEquals('Test Campaign', $command->name());
        $this->assertEquals(new \DateTimeImmutable('2026-01-01'), $command->startDate());
        $this->assertEquals(new \DateTimeImmutable('2026-01-01'), $command->endDate());
    }
}
