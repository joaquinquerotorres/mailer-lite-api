<?php

declare(strict_types=1);

namespace App\Campaign\Application\SendCampaign;

use App\Campaign\Domain\DTO\CampaignDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CampaignDTO $campaign,
        private string $fromAddress,
        private string $subjectLine,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->fromAddress),
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.campaign-sent',
        );
    }
}
