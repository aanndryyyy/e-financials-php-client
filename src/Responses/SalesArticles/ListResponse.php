<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesArticles;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type SalesArticleData from SalesArticleResponse
 *
 * @implements ResponseContract<array<int, SalesArticleData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, SalesArticleData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, SalesArticleResponse>  $data
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
            static fn (array $item): SalesArticleResponse => SalesArticleResponse::from($item),
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
            static fn (SalesArticleResponse $item): array => $item->toArray(),
            $this->data,
        );
    }
}
