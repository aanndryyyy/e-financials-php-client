<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\CostProfitCentres;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type CostProfitCentreData from CostProfitCentreResponse
 *
 * @implements ResponseContract<array{current_page: int, total_pages: int, items: array<int, CostProfitCentreData>}>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{current_page: int, total_pages: int, items: array<int, CostProfitCentreData>}>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, CostProfitCentreResponse>  $items
     */
    private function __construct(
        public readonly int $currentPage,
        public readonly int $totalPages,
        public readonly array $items,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<int, array<string, mixed>> $rawItems */
        $rawItems = is_array($attributes['items'] ?? null) ? $attributes['items'] : [];

        $items = array_map(
            static fn (array $item): CostProfitCentreResponse => CostProfitCentreResponse::from($item),
            $rawItems,
        );

        return new self(
            self::intValue($attributes['current_page'] ?? 0),
            self::intValue($attributes['total_pages'] ?? 0),
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
                static fn (CostProfitCentreResponse $item): array => $item->toArray(),
                $this->items,
            ),
        ];
    }
}
