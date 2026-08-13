<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use App\Shared\Domain\Bus\QueryBus;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetCampaignsController
{
    public function __construct(
        private QueryBus $queryBus
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $cursor = $request->query('cursor') ?? '';
        $limit = $request->integer('limit') ?? 10;
        $cursor = new CursorValueObject($cursor);
        $limit = new LimitValueObject($limit);

        $query = new GetCampaignsQuery($cursor, $limit);

        $cursorPagination = $this->queryBus->ask($query);

        return response()->json($cursorPagination);

    }
}
