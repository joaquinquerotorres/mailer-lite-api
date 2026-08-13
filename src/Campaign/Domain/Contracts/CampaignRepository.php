<?php

declare(strict_types=1);

namespace App\Campaign\Domain\Contracts;

use App\Shared\Domain\Pagination\CursorPagination;

interface CampaignRepository
{
    public function paginate(?string $cursor, int $limit): CursorPagination;
}
