<?php

declare(strict_types=1);

namespace App\Campaign\Application\SendCampaign;

use App\Campaign\Domain\Contracts\CampaignRepository;
use App\Campaign\Domain\ValueObjects\CampaignUuidValueObject;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

final class SendCampaignCommandHandler
{
    public const string EMAIL_TO = 'joaquinquerotorres@gmail.com';

    public const string EMAIL_FROM = 'campaigns@mailerlite.com';

    public const string EMAIL_SUBJECT = 'Campaign sent';

    public const string REDIS_KEY = 'campaign:sent:';

    public const int LOCK_TTL_SECONDS = 60;

    public function __construct(private CampaignRepository $campaignRepository) {}

    public function __invoke(SendCampaignCommand $command): void
    {
        $lock = Cache::lock(self::REDIS_KEY.$command->campaignUuid(), self::LOCK_TTL_SECONDS);

        if (! $lock->get()) {
            return;
        }

        try {
            $campaignUuid = new CampaignUuidValueObject($command->campaignUuid());
            $campaign = $this->campaignRepository->find($campaignUuid);

            Mail::to(self::EMAIL_TO)->send(new SendCampaignMail(
                $campaign,
                self::EMAIL_FROM,
                self::EMAIL_SUBJECT,
            ));
        } finally {
            $lock->release();
        }
    }
}
