<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class GetCampaignUseCase
{
    public function __construct(private CampaignRepository $repository) {}

    public function __invoke(CampaignUuidValueObject $campaignUuid): Campaign
    {
        return $this->repository->find($campaignUuid);
    }
}
