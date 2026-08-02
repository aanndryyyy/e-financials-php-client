<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Clients;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, ClientResponse>  $items
     */
    private function __construct(
        public readonly int $currentPage,
        public readonly int $totalPages,
        public readonly array $items,
    ) {}

    /**
     * @param  array{current_page: int, total_pages: int, items: array<int, array<string, mixed>>}  $attributes
     */
    public static function from(array $attributes): self
    {
        $items = array_map(
            static fn (array $item): ClientResponse => ClientResponse::from($item),
            $attributes['items'],
        );

        return new self(
            (int) $attributes['current_page'],
            (int) $attributes['total_pages'],
            $items,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'items' => array_map(
                static fn (ClientResponse $client): array => $client->toArray(),
                $this->items,
            ),
        ];
    }
}
