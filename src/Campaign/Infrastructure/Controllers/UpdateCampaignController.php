<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommand;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UpdateCampaignController
{
    public function __construct(private CommandBus $commandBus) {}

    public function __invoke(string $campaignUuid, Request $request): JsonResponse
    {
        $name = $request->name;
        $startDate = new \DateTimeImmutable($request->startDate);
        $endDate = new \DateTimeImmutable($request->endDate);

        $command = new UpdateCampaignCommand($campaignUuid, $name, $startDate, $endDate);
        $this->commandBus->dispatch($command);

        return response()->json([
            'message' => 'Campaign updated successfully'
        ], 200);
    }
}