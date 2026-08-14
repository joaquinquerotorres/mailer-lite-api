<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Shared\Domain\Bus\Query;

final class GetCampaignQuery implements Query
{
    public function __construct(private string $campaignUuid) {}

    public function campaignUuid(): string
    {
        return $this->campaignUuid;
    }
}
