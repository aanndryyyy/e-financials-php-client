<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Accounts;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type AccountData from AccountResponse
 *
 * @implements ResponseContract<array<int, AccountData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, AccountData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, AccountResponse>  $data
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
            static fn (array $item): AccountResponse => AccountResponse::from($item),
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
            static fn (AccountResponse $item): array => $item->toArray(),
            $this->data,
        );
    }
}
