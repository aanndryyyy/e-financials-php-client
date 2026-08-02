<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Bank;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @phpstan-import-type BankAccountData from BankAccountResponse
 *
 * @implements ResponseContract<array<int, BankAccountData>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, BankAccountData>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, BankAccountResponse>  $data
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
            static fn (array $item): BankAccountResponse => BankAccountResponse::from($item),
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
            static fn (BankAccountResponse $item): array => $item->toArray(),
            $this->data,
        );
    }
}
