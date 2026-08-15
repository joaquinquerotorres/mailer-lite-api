<?php

declare(strict_types=1);

namespace App\Campaign\Application\UpdateCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class UpdateCampaignCommandHandler
{
    public function __construct(private CampaignRepository $campaignRepository) {}

    public function __invoke(UpdateCampaignCommand $command): void
    {
        $campaign = new Campaign(
            new CampaignUuidValueObject($command->campaignUuid()),
            new CampaignNameValueObject($command->name()),
            new CampaignDateRangeValueObject($command->startDate(), $command->endDate())
        );

        $this->campaignRepository->update($campaign);
    }
}