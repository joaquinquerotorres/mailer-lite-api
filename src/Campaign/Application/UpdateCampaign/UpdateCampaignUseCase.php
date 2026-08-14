<?php

declare(strict_types=1);

namespace App\Campaign\Application\UpdateCampaign;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository;

class UpdateCampaignUseCase
{
    public function __construct(private CampaignRepository $repository) {}

    public function __invoke(Campaign $campaign): void
    {
        $this->repository->update($campaign);
    }
}