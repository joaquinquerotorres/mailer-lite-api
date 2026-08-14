<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\UpdateCampaign;

use App\Campaign\Application\UpdateCampaign\UpdateCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class UpdateCampaignUseCaseTest extends TestCase
{
    public function test_it_should_return_a_update_campaign_use_case()
    {
        $campaign = new Campaign(
            new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000'),
            new CampaignNameValueObject('Test Campaign'),
            new CampaignDateRangeValueObject(new \DateTimeImmutable('+1 day'), new \DateTimeImmutable('+2 days'))
        );
        $repository = $this->createMock(CampaignRepository::class);
        $repository->expects($this->once())->method('update')->with($campaign);
        $useCase = new UpdateCampaignUseCase($repository);
        $useCase->__invoke($campaign);

        $this->assertInstanceOf(UpdateCampaignUseCase::class, $useCase);
    }
}