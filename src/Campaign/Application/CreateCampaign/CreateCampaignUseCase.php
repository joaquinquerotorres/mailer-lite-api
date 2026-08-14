<?php

declare(strict_types=1);

namespace App\Campaign\Application\CreateCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;

class CreateCampaignUseCase
{
    public function __construct(private CampaignRepository $repository) {}

    public function __invoke(Campaign $campaign): void
    {
        $this->repository->create($campaign);

        $campaign->create();
    }
}
