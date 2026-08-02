<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Currencies;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{id: string, name_est: string|null, name_eng: string|null}>
 */
final class CurrencyResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: string, name_est: string|null, name_eng: string|null}>
     */
    use ArrayAccessible;

    use Fakeable;

    private function __construct(
        public readonly string $id,
        public readonly ?string $nameEst,
        public readonly ?string $nameEng,
    ) {}

    /**
     * @param  array{id: string, name_est?: string|null, name_eng?: string|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            $attributes['id'],
            $attributes['name_est'] ?? null,
            $attributes['name_eng'] ?? null,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name_est' => $this->nameEst,
            'name_eng' => $this->nameEng,
        ];
    }
}
