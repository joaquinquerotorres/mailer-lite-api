<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Repository;

use App\Campaign\Domain\Campaign;
use App\Campaign\Domain\Contracts\CampaignRepository as CampaignRepositoryContract;
use App\Campaign\Domain\ValueObjects\CampaignDateRangeValueObject;
use App\Campaign\Domain\ValueObjects\CampaignNameValueObject;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Shared\Domain\Pagination\CursorPagination;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CampaignEloquentRepository implements CampaignRepositoryContract
{
    public function paginate(CursorValueObject $cursor, LimitValueObject $limit): CursorPagination
    {
        $paginator = CampaignEloquent::orderBy('created_at', 'desc')
            ->cursorPaginate($limit->value(), ['*'], 'cursor', $cursor->value());

        $items = [];
        foreach ($paginator->items() as $model) {
            $items[] = $this->mapToDomain($model);
        }

        return new CursorPagination(
            $items,
            $paginator->nextCursor()?->encode(),
            $paginator->previousCursor()?->encode()
        );
    }

    public function find(CampaignUuidValueObject $id): Campaign
    {
        $model = CampaignEloquent::where('uuid', $id->value())->first();
        if (! $model) {
            throw new NotFoundHttpException('Campaign not found with uuid: '.$id->value());
        }

        return $this->mapToDomain($model);
    }

    public function create(Campaign $campaign): void
    {
        CampaignEloquent::create($this->mapToEloquent($campaign));
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

    private function mapToEloquent(Campaign $campaign): CampaignEloquent
    {
        return new CampaignEloquent([
            'uuid' => $campaign->uuid()->value(),
            'name' => $campaign->name()->value(),
            'start_date' => $campaign->dateRange()->startDate()->format('Y-m-d H:i:s'),
            'end_date' => $campaign->dateRange()->endDate()->format('Y-m-d H:i:s'),
        ]);
    }
}
