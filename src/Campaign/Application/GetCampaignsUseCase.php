<?php

declare(strict_types=1);

namespace App\Campaign\Application;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Shared\Domain\Pagination\CursorPagination;

final class GetCampaignsUseCase
{
    public function __construct(private CampaignRepository $repository) {}

    public function __invoke(?string $cursor, int $limit): CursorPagination
    {
        return $this->repository->paginate($cursor, $limit);
    }
}
