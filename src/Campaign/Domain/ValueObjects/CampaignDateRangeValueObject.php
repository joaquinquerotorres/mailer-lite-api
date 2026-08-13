<?php

declare(strict_types=1);

namespace App\Campaign\Domain\ValueObjects;

final class CampaignDateRangeValueObject
{
    public function __construct(
        private \DateTimeImmutable $startDate,
        private \DateTimeImmutable $endDate
    ) {
        $this->validate($startDate, $endDate);
    }

    public function startDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    private function validate(\DateTimeImmutable $startDate, \DateTimeImmutable $endDate): void
    {
        $now = new \DateTimeImmutable('now');

        if ($startDate < $now) {
            throw new \InvalidArgumentException('Campaign start date cannot be in the past.');
        }

        if ($startDate > $endDate) {
            throw new \InvalidArgumentException('Start date must be before end date.');
        }
    }
}