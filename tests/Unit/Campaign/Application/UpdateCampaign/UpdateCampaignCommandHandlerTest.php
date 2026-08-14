<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\UpdateCampaign;

use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommand;
use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommandHandler;
use App\Campaign\Application\UpdateCampaign\UpdateCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class UpdateCampaignCommandHandlerTest extends TestCase
{
    public function test_it_should_return_a_update_campaign_command_handler()
    {
        $command = new UpdateCampaignCommand('123e4567-e89b-12d3-a456-426614174000', 'Test Campaign', new \DateTimeImmutable('+1 day'), new \DateTimeImmutable('+2 days'));

        $campaign = new Campaign(
            new CampaignUuidValueObject($command->campaignUuid()),
            new CampaignNameValueObject($command->name()),
            new CampaignDateRangeValueObject($command->startDate(), $command->endDate())
        );
        $useCase = $this->createMock(UpdateCampaignUseCase::class);
        $useCase->expects($this->once())->method('__invoke')->with($campaign);
        $commandHandler = new UpdateCampaignCommandHandler($useCase);

        $commandHandler->__invoke($command);

        $this->assertInstanceOf(Campaign::class, $campaign);
        $this->assertEquals($command->campaignUuid(), $campaign->uuid()->value());
        $this->assertEquals($command->name(), $campaign->name()->value());
        $this->assertEquals($command->startDate(), $campaign->dateRange()->startDate());
        $this->assertEquals($command->endDate(), $campaign->dateRange()->endDate());
    }
}
