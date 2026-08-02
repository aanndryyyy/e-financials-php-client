<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\PurchaseArticles;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type PurchaseArticleData from PurchaseArticleResponse
 *
 * @implements ResponseContract<array<int, PurchaseArticleData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, PurchaseArticleData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, PurchaseArticleResponse>  $data
     */
    private function __construct(public readonly array $data)
    {
        // ..
    }

    /**
     * @param  array<int, array<array-key, mixed>>  $attributes
     */
    public static function from(array $attributes): self
    {
        $data = array_map(
            static fn (array $item): PurchaseArticleResponse => PurchaseArticleResponse::from($item),
            array_values($attributes),
        );

        return new self($data);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return array_map(
            static fn (PurchaseArticleResponse $item): array => $item->toArray(),
            $this->data,
        );
    }
}
