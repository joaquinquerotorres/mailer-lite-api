<?php

declare(strict_types=1);

namespace App\Tests\Feature\Campaign\Controllers;

use App\Campaign\Application\CreateCampaign\CreateCampaignCommand;
use App\Campaign\Infrastructure\Controllers\CreateCampaignController;
use App\Http\Requests\CreateCampaignRequest;
use App\Shared\Domain\Bus\CommandBus;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

final class CreateCampaignControllerTest extends TestCase
{
    public function test_it_should_create_a_campaign(): void
    {
        $name = 'Test Campaign';
        $startDate = new \DateTimeImmutable('2027-01-05 09:00:00');
        $endDate = new \DateTimeImmutable('2027-01-31 18:00:00');

        $request = CreateCampaignRequest::create('/api/campaigns', 'POST', [
            'name' => $name,
            'startDate' => $startDate->format('Y-m-d H:i:s'),
            'endDate' => $endDate->format('Y-m-d H:i:s'),
        ]);
        $request->setContainer($this->app);
        $request->setRedirector($this->app->make('redirect'));
        $request->validateResolved();

        $commandBus = $this->createMock(CommandBus::class);
        $commandBus->expects($this->once())
            ->method('dispatch')
            ->with($this->callback(function (CreateCampaignCommand $command) use ($name, $startDate, $endDate): bool {
                return Uuid::isValid($command->uuid())
                    && $command->name() === $name
                    && $command->startDate() == $startDate
                    && $command->endDate() == $endDate;
            }));

        $controller = new CreateCampaignController($commandBus);
        $response = $controller->__invoke($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-Type'));
        $this->assertEquals('{"message":"Campaign created successfully"}', $response->getContent());
    }
}
