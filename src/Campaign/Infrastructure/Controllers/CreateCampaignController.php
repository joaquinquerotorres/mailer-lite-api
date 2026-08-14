<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class CreateCampaignController
{
    public function __construct(private CommandBus $commandBus) {}

    public function __invoke(Request $request): JsonResponse
    {
        $uuid = Uuid::uuid4()->toString();
        $name = $request->name;
        $startDate = new \DateTimeImmutable($request->startDate);
        $endDate = new \DateTimeImmutable($request->endDate);

        $command = new CreateCampaignCommand($uuid, $name, $startDate, $endDate);
        $this->commandBus->dispatch($command);

        return response()->json([
            'message' => 'Campaign created successfully',
        ]);
    }
}
