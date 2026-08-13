<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\GetCampaign\GetCampaignQuery;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use App\Http\Resources\CampaignResource;
use App\Shared\Domain\Bus\QueryBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class GetCampaignController
{
    public function __construct(private QueryBus $queryBus) {}

    public function __invoke(Request $request): JsonResponse
    {
        $campaignUuid = new CampaignUuidValueObject($request->route('campaignUuid'));
        $query = new GetCampaignQuery($campaignUuid);

        $campaign = $this->queryBus->ask($query);

        return response()->json(new CampaignResource($campaign));
    }
}
