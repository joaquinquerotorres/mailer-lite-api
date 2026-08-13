<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaigns;

use App\Shared\Domain\Bus\Query;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

final class GetCampaignsQuery implements Query
{
    public function __construct(
        public readonly CursorValueObject $cursor,
        public readonly LimitValueObject $limit
    ) {}
}
