<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Invoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type InvoiceSeriesData from InvoiceSeriesResponse
 *
 * @implements ResponseContract<array<int, InvoiceSeriesData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, InvoiceSeriesData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, InvoiceSeriesResponse>  $data
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
            static fn (array $item): InvoiceSeriesResponse => InvoiceSeriesResponse::from($item),
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
            static fn (InvoiceSeriesResponse $series): array => $series->toArray(),
            $this->data,
        );
    }
}
