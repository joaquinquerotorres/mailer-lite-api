<?php

declare(strict_types=1);

namespace App\Campaign\Domain\Contracts;

use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

interface CampaignRepository
{
    public function paginate(CursorValueObject $cursor, LimitValueObject $limit): CursorPagination;
}
