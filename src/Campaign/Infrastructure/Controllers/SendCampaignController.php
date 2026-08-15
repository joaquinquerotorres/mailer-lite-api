<?php

declare(strict_types=1);

namespace App\Campaign\Infrastructure\Controllers;

use App\Campaign\Application\SendCampaign\SendCampaignCommand;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class SendCampaignController
{
    public function __construct(
        private CommandBus $commandBus
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $this->commandBus->dispatch(new SendCampaignCommand(
            $request->campaignUuid
        ));

        return response()->json([
            'message' => 'Campaign sent successfully',
        ], Response::HTTP_ACCEPTED);
    }
}
