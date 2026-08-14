<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Http\Requests\CreateCampaignRequest;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Ramsey\Uuid\Uuid;

class CreateCampaignController
{
    public function __construct(private CommandBus $commandBus) {}

    public function __invoke(CreateCampaignRequest $request): JsonResponse
    {
        $cleanData = $request->validated();
        $uuid = Uuid::uuid4()->toString();
        $name = $cleanData['name'];
        $startDate = new \DateTimeImmutable($cleanData['startDate']);
        $endDate = new \DateTimeImmutable($cleanData['endDate']);

        $command = new CreateCampaignCommand($uuid, $name, $startDate, $endDate);
        $this->commandBus->dispatch($command);

        return response()->json([
            'message' => 'Campaign created successfully',
        ], Response::HTTP_CREATED);
    }
}
