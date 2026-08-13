<?php

declare(strict_types=1);

namespace App\Shared\Domain\Pagination;

final class CursorPagination
{
    public function __construct(
        public readonly array $items,
        public readonly ?string $nextCursor,
        public readonly ?string $prevCursor,
    ) {}
}
