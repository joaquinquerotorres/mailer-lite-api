<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Http\Resources\CampaignResource;
use App\Shared\Domain\Bus\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class GetCampaignController
{
    public function __construct(private QueryBus $queryBus) {}

    public function __invoke(string $campaignUuid): JsonResponse
    {
        $query = new GetCampaignQuery($campaignUuid);

        $campaignDTO = $this->queryBus->ask($query);

        return response()->json(new CampaignResource($campaignDTO), Response::HTTP_OK);
    }
}
