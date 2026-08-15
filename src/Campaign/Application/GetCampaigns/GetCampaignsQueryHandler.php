<?php

declare(strict_types=1);

namespace App\Campaign\Application\GetCampaigns;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

final class GetCampaignsQueryHandler
{
    public function __construct(
        private CampaignRepository $campaignRepository
    ) {}

    public function __invoke(GetCampaignsQuery $query): CursorPagination
    {
        $cursor = new CursorValueObject($query->cursor());
        $limit = new LimitValueObject((int) $query->limit());

        return $this->campaignRepository->paginate($cursor, $limit);
    }
}
