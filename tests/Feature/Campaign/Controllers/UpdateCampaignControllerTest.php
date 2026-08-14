<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Campaign\Application\UpdateCampaign\UpdateCampaignCommand;
use App\Campaign\Infrastructure\Controllers\CreateCampaignController;
use App\Campaign\Infrastructure\Controllers\UpdateCampaignController;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class UpdateCampaignControllerTest extends TestCase
{
    public function test_it_should_create_a_campaign(): void
    {
        $name = 'Test Campaign';
        $startDate = new \DateTimeImmutable('2027-01-05 09:00:00');
        $endDate = new \DateTimeImmutable('2027-01-31 18:00:00');

        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $request = Request::create('/api/campaigns/' . $uuid, 'PUT', [
            'name' => $name,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s'),
        ]);

        $commandBus = $this->createMock(CommandBus::class);
        $commandBus->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function (UpdateCampaignCommand $command) use ($uuid, $name, $startDate, $endDate): bool {
                return Uuid::isValid($command->campaignUuid())
                    && $command->name() === $name
                    && $command->startDate() == $startDate
                    && $command->endDate() == $endDate;
            }));

        $controller = new UpdateCampaignController($commandBus);
        $response = $controller->__invoke($uuid, $request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals('{"message":"Campaign updated successfully"}', $response->getContent());
    }
}
