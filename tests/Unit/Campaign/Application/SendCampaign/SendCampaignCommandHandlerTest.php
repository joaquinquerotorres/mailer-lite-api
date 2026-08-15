<?php

declare(strict_types=1);

namespace App\Tests\Unit\Campaign\Application\SendCampaign;

use App\Campaign\Application\SendCampaign\SendCampaignCommand;
use App\Campaign\Application\SendCampaign\SendCampaignCommandHandler;
use App\Campaign\Application\SendCampaign\SendCampaignMail;
use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\DTO\CampaignDTO;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

final class SendCampaignCommandHandlerTest extends TestCase
{
    public function test_it_should_invoke_the_send_campaign_command_handler(): void
    {
        Mail::fake();

        $uuid = '123e4567-e89b-12d3-a456-426614174000';
        $campaign = new CampaignDTO(
            $uuid,
            'Test Campaign',
            new \DateTimeImmutable('+1 day'),
            new \DateTimeImmutable('+2 days'),
        );

        $campaignRepository = $this->createMock(CampaignRepository::class);
        $campaignRepository->expects($this->once())
            ->method('find')
            ->with(new CampaignUuidValueObject($uuid))
            ->willReturn($campaign);

        $handler = new SendCampaignCommandHandler($campaignRepository);
        $handler->__invoke(new SendCampaignCommand($uuid));

        Mail::assertSent(SendCampaignMail::class, function (SendCampaignMail $mail) use ($campaign): bool {
            return $mail->campaign === $campaign
                && $mail->hasTo(SendCampaignCommandHandler::EMAIL_TO)
                && $mail->hasFrom(SendCampaignCommandHandler::EMAIL_FROM)
                && $mail->hasSubject(SendCampaignCommandHandler::EMAIL_SUBJECT);
        });
    }
}
