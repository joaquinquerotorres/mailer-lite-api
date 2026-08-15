<?php

declare(strict_types=1);

namespace App\Campaign\Application\SendCampaign;

use App\Shared\Domain\Bus\Command;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

final class SendCampaignCommand implements Command, ShouldQueue
{
    use Queueable;

    public function backoff(): array
    {
        return [60, 120, 180];
    }

    public function __construct(
        private string $campaignUuid
    ) {}

    public function campaignUuid(): string
    {
        return $this->campaignUuid;
    }
}
