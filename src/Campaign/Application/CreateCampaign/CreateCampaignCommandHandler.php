<?php

declare(strict_types=1);

namespace App\Campaign\Application\CreateCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class CreateCampaignCommandHandler
{
    public function __construct(private CampaignRepository $campaignRepository) {}

    public function __invoke(CreateCampaignCommand $command): void
    {
        $uuid = new CampaignUuidValueObject($command->uuid());
        $name = new CampaignNameValueObject($command->name());
        $dateRange = new CampaignDateRangeValueObject($command->startDate(), $command->endDate());

        $campaign = new Campaign($uuid, $name, $dateRange);

        $this->campaignRepository->create($campaign);
    }
}
