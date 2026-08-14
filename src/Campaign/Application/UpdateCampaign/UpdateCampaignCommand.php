<?php

declare(strict_types=1);

namespace App\Campaign\Application\UpdateCampaign;

use App\Shared\Domain\Bus\Command;

final class UpdateCampaignCommand implements Command
{
    public function __construct(private string $campaignUuid, private string $name, private \DateTimeImmutable $startDate, private \DateTimeImmutable $endDate) {}

    public function campaignUuid(): string
    {
        return $this->campaignUuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }
    
    public function endDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }
}