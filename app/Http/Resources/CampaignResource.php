<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Campaign\Domain\DTO\CampaignDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var CampaignDTO $campainDTO */
        $campainDTO = $this->resource;

        return [
            'id' => $campainDTO->uuid(),
            'name' => $campainDTO->name(),
            'startDate' => $campainDTO->startDate()->format('Y-m-d'),
            'endDate' => $campainDTO->endDate()->format('Y-m-d'),
        ];
    }
}
