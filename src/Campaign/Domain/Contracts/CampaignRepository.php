<?php

declare(strict_types=1);

namespace App\Campaign\Domain\Contracts;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;

interface CampaignRepository
{
    public function paginate(CursorValueObject $cursor, LimitValueObject $limit): CursorPagination;

    public function find(CampaignUuidValueObject $id): CampaignDTO;

    public function create(Campaign $campaign): void;

    public function update(Campaign $campaign): void;
}
