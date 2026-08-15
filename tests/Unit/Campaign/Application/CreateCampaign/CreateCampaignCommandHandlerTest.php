<?php

declare(strict_types=1);

namespace Tests\Unit\Campaign\Application\CreateCampaign;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Campaign\Application\CreateCampaign\CreateCampaignCommandHandler;
use App\Campaign\Application\CreateCampaign\CreateCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
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

        $campaign = new Campaign(
            new CampaignUuidValueObject($command->uuid()),
            new CampaignNameValueObject($command->name()),
            new CampaignDateRangeValueObject($command->startDate(), $command->endDate())
        );

        $repository = $this->createMock(CampaignRepository::class);
        $repository->expects($this->once())->method('create')->with($campaign);
        $handler = new CreateCampaignCommandHandler($repository);
        $handler->__invoke($command);

        $this->assertTrue(true);
        $this->expectNotToPerformAssertions();
    }
}
