<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\CreateCampaign;

use App\Campaign\Application\CreateCampaign\CreateCampaignUseCase;
use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use PHPUnit\Framework\TestCase;

final class CreateCampaignUseCaseTest extends TestCase
{
    public function test_it_should_return_a_create_campaign_use_case()
    {
        $uuid = new CampaignUuidValueObject('123e4567-e89b-12d3-a456-426614174000');
        $campaign = new Campaign(
            $uuid,
            new CampaignNameValueObject('Spring launch'),
            new CampaignDateRangeValueObject(
                new \DateTimeImmutable('+10 days'),
                new \DateTimeImmutable('+20 days')
            )
        );

        $repository = $this->createMock(CampaignRepository::class);
        $repository->expects($this->once())->method('create')->with($campaign);
        $useCase = new CreateCampaignUseCase($repository);
        $useCase->__invoke($campaign);

        $this->assertTrue(true);
        $this->expectNotToPerformAssertions();
    }
}
