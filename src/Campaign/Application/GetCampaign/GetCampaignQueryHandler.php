<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class GetCampaignQueryHandler
{
    public function __construct(private GetCampaignUseCase $getCampaignUseCase) {}

    public function __invoke(GetCampaignQuery $query): Campaign
    {
        $campaignUuid = new CampaignUuidValueObject($query->campaignUuid());

        return $this->getCampaignUseCase->__invoke($campaignUuid);
    }
}
