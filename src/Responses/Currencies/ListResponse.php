<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Currencies;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array<int, array{id: string, name_est: string|null, name_eng: string|null}>>
 */
final class ListResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<int, array{id: string, name_est: string|null, name_eng: string|null}>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<int, CurrencyResponse>  $data
     */
    private function __construct(public readonly array $data)
    {
        // ..
    }

    /**
     * @param  array<int, array{id: string, name_est?: string|null, name_eng?: string|null}>  $attributes
     */
    public static function from(array $attributes): self
    {
        $data = array_map(
            static fn (array $item): CurrencyResponse => CurrencyResponse::from($item),
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
            static fn (CurrencyResponse $currency): array => $currency->toArray(),
            $this->data,
        );
    }
}
