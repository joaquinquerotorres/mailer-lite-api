<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Repository;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository as CampaignRepositoryContract;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Shared\Domain\Pagination\CursorPagination;
use Carbon\Carbon;

class CampaignEloquentRepository implements CampaignRepositoryContract
{
    public function paginate(?string $cursor, int $limit): CursorPagination
    {
        $paginator = CampaignEloquent::orderBy('created_at', 'desc')
            ->cursorPaginate($limit, ['*'], 'cursor', $cursor);

        $items = [];
        foreach ($paginator->items() as $model) {
            $items[] = $this->mapToDomain($model);
        }

        return new CursorPagination(
            $items,
            $paginator->nextCursor()?->encode(), // Devuelve el string base64 o null
            $paginator->previousCursor()?->encode()
        );
    }

    private function mapToDomain(CampaignEloquent $model): Campaign
    {
        $startDate = $model->start_date instanceof Carbon
        ? $model->start_date->toDateTimeImmutable()
        : new \DateTimeImmutable($model->start_date);

        $endDate = $model->end_date instanceof Carbon
            ? $model->end_date->toDateTimeImmutable()
            : new \DateTimeImmutable($model->end_date);

        $dateRange = new CampaignDateRangeValueObject($startDate, $endDate);

        return new Campaign(
            new CampaignUuidValueObject($model->uuid),
            new CampaignNameValueObject($model->name),
            $dateRange,
        );
    }
}
