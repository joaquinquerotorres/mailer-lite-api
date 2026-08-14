<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaigns;

use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

final class GetCampaignsQueryHandler
{
    public function __construct(
        private GetCampaignsUseCase $getCampaignsUseCase
    ) {}

    public function __invoke(GetCampaignsQuery $query): CursorPagination
    {
        $cursor = new CursorValueObject($query->cursor());
        $limit = new LimitValueObject((int) $query->limit());

        return $this->getCampaignsUseCase->__invoke($cursor, $limit);
    }
}
