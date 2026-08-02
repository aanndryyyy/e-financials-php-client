<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\AccountDimensions;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type AccountDimensionData from AccountDimensionResponse
 *
 * @implements ResponseContract<array<int, AccountDimensionData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, AccountDimensionData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, AccountDimensionResponse>  $data
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
            static fn (array $item): AccountDimensionResponse => AccountDimensionResponse::from($item),
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
            static fn (AccountDimensionResponse $item): array => $item->toArray(),
            $this->data,
        );
    }
}
