<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\GetCampaigns\GetCampaignsQuery;
use App\Http\Resources\CursorResource;
use App\Shared\Domain\Bus\QueryBus;
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

        $query = new GetCampaignsQuery($cursor, $limit);

        $cursorPagination = $this->queryBus->ask($query);

        return response()->json(new CursorResource($cursorPagination));

    }
}
