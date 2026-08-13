<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaign;

use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Shared\Domain\Bus\Query;

final class GetCampaignQuery implements Query
{
    public function __construct(public readonly CampaignUuidValueObject $campaignUuid) {}
}
