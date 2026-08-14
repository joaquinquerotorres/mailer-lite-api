<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommand;
use App\Http\Requests\UpdateCampaignRequest;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class UpdateCampaignController
{
    public function __construct(private CommandBus $commandBus) {}

    public function __invoke(string $campaignUuid, UpdateCampaignRequest $request): JsonResponse
    {
        $cleanData = $request->validated();
        $name = $cleanData['name'];
        $startDate = new \DateTimeImmutable($cleanData['startDate']);
        $endDate = new \DateTimeImmutable($cleanData['endDate']);

        $command = new UpdateCampaignCommand($campaignUuid, $name, $startDate, $endDate);
        $this->commandBus->dispatch($command);

        return response()->json([
            'message' => 'Campaign updated successfully'
        ], Response::HTTP_OK);
    }
}