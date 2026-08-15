<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;

final class GetCampaignQueryHandler
{
    public function __construct(private CampaignRepository $campaignRepository) {}

    public function __invoke(GetCampaignQuery $query): CampaignDTO
    {
        $campaignUuid = new CampaignUuidValueObject($query->campaignUuid());

        return $this->campaignRepository->find($campaignUuid);
    }
}
