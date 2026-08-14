<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Shared\Domain\Pagination\CursorPagination;

class CursorResource extends JsonResource
{
    public function toArray($request)
    {
        /** @var CursorPagination $cursorPagination */
        $cursorPagination = $this->resource;

        $items = CampaignResource::collection($cursorPagination->items);

        return [
            'items' => $items,
            'nextCursor' => $cursorPagination->nextCursor,
            'prevCursor' => $cursorPagination->prevCursor,
        ];
    }
}