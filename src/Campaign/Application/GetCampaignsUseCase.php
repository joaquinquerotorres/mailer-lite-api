<?php

declare(strict_types=1);

namespace App\Campaign\Application;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

final class GetCampaignsUseCase
{
    public function __construct(private CampaignRepository $repository) {}

    public function __invoke(CursorValueObject $cursor, LimitValueObject $limit): CursorPagination
    {
        if ($limit->value() > 100) {
            $limit = 100;
        }

        if ($limit->value() <= 0) {
            $limit = 10;
        }

        return $this->repository->paginate($cursor, $limit);
    }
}
