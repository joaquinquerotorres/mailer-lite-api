<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\GetCampaignsUseCase;
use App\Shared\Domain\Pagination\ValueObjects\CursorValueObject;
use App\Shared\Domain\Pagination\ValueObjects\LimitValueObject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetCampaignsController
{
    public function __construct(
        private GetCampaignsUseCase $getCampaignsUseCase
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $cursor = $request->query('cursor');
        $limit = $request->integer('limit');
        $cursor = new CursorValueObject($cursor);
        $limit = new LimitValueObject($limit);

        $cursorPagination = $this->getCampaignsUseCase->__invoke($cursor, $limit);

        return response()->json($cursorPagination);
    }
}
