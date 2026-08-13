<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Campaign\Domain\Campaign;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Campaign $campain */
        $campain = $this->resource;

        return [
            'id' => $campain->uuid()->value(),
            'name' => $campain->name()->value(),
            'startDate' => $campain->dateRange()->startDate()->format('Y-m-d'),
            'endDate' => $campain->dateRange()->endDate()->format('Y-m-d'),
        ];
    }
}
