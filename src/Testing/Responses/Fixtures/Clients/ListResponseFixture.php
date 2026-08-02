<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Clients;

final class ListResponseFixture
{
    /**
     * @var array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}
     */
    public const ATTRIBUTES = [
        'current_page' => 1,
        'total_pages' => 1,
        'items' => [
            ClientResponseFixture::ATTRIBUTES,
        ],
    ];
}
