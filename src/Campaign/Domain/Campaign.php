<?php

declare(strict_types=1);

namespace App\Campaign\Domain;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Campaign\Domain\Events\CampaignPublishedEvent;


final class Campaign extends AggregateRoot
{
    public function __construct(
        private CampaignUuidValueObject $uuid,
        private CampaignNameValueObject $name,
        private CampaignDateRangeValueObject $dateRange
    ) {
    }

    public function uuid(): CampaignUuidValueObject
    {
        return $this->uuid;
    }

    public function name(): CampaignNameValueObject
    {
        return $this->name;
    }

    public function dateRange(): CampaignDateRangeValueObject
    {
        return $this->dateRange;
    }

    public function publish(): void
    {
        $this->record(new CampaignPublishedEvent($this->uuid->value()));
    }
}