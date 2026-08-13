<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Campaign\Domain\Campaign;

final class GetCampaignQueryHandler
{
    public function __construct(private GetCampaignUseCase $getCampaignUseCase) {}

    public function __invoke(GetCampaignQuery $query): Campaign
    {
        return $this->getCampaignUseCase->__invoke($query->campaignUuid);
    }
}
