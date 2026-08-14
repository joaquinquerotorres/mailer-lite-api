<?php

declare(strict_types=1);

namespace App\Campaign\Domain\Events;

use App\Shared\Domain\Event\DomainEvent;

final class CampaignCreatedEvent implements DomainEvent
{
    private \DateTimeImmutable $occurredOn;

    public function __construct(
        private readonly string $campaignUuid,
    ) {
        $this->occurredOn = new \DateTimeImmutable;
    }

    public function occurredOn(): \DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function eventName(): string
    {
        return 'campaign.created';
    }

    public function campaignUuid(): string
    {
        return $this->campaignUuid;
    }
}
