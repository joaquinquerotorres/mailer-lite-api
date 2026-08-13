<?php

declare(strict_types=1);

namespace App\Campaign\Application;

use App\Shared\Domain\Pagination\CursorPagination;

final class GetCampaignsQueryHandler
{
    public function __construct(
        private GetCampaignsUseCase $getCampaignsUseCase
    ) {}

    public function __invoke(GetCampaignsQuery $query): CursorPagination
    {
        return $this->getCampaignsUseCase->__invoke($query->cursor, $query->limit);
    }
}