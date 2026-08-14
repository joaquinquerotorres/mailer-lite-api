<?php

declare(strict_types=1);

namespace Tests\Unit\Campaign\Application\CreateCampaign;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Campaign\Application\CreateCampaign\CreateCampaignCommandHandler;
use App\Campaign\Application\CreateCampaign\CreateCampaignUseCase;
use App\Campaign\Domain\Campaign;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class CreateCampaignCommandHandlerTest extends TestCase
{
    public function test_it_should_create_a_campaign()
    {
        $command = new CreateCampaignCommand(
            Uuid::uuid4()->toString(),
            'Test Campaign',
            new \DateTimeImmutable('now')->modify('+1 day'),
            new \DateTimeImmutable('now')->modify('+2 day')
        );

        $createCampaignUseCase = $this->createMock(CreateCampaignUseCase::class);
        $createCampaignUseCase->expects($this->once())->method('__invoke')->with($this->callback(function (Campaign $campaign) use ($command) {
            return $campaign->uuid()->value() === $command->uuid() && $campaign->name()->value() === $command->name() && $campaign->dateRange()->startDate() === $command->startDate() && $campaign->dateRange()->endDate() === $command->endDate();
        }));
        $handler = new CreateCampaignCommandHandler($createCampaignUseCase);
        $handler->__invoke($command);

        $this->assertTrue(true);
        $this->expectNotToPerformAssertions();
    }
}
