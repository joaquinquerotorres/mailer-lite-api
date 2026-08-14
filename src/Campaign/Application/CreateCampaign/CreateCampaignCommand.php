<?php

declare(strict_types=1);

namespace App\Campaign\Application\CreateCampaign;

use App\Shared\Domain\Bus\Command;

final class CreateCampaignCommand implements Command
{
    public function __construct(
        private string $uuid,
        private string $name,
        private \DateTimeImmutable $startDate,
        private \DateTimeImmutable $endDate) {}

    public function uuid(): string
    {
        return $this->uuid;
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
