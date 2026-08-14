<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaigns;

use App\Shared\Domain\Bus\Query;

final class GetCampaignsQuery implements Query
{
    public function __construct(
        private string $cursor,
        private int $limit
    ) {}

    public function cursor(): string
    {
        return $this->cursor;
    }

    public function limit(): int
    {
        return $this->limit;
    }
}
