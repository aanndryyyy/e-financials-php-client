<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\VatInfo;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{vat_number: string|null, tax_refnumber: string|null}>
 */
final class VatInfoResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{vat_number: string|null, tax_refnumber: string|null}>
     */
    use ArrayAccessible;

    use Fakeable;

    private function __construct(
        public readonly ?string $vatNumber,
        public readonly ?string $taxRefnumber,
    ) {}

    /**
     * @param  array{vat_number?: string|null, tax_refnumber?: string|null}  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            isset($attributes['vat_number']) && $attributes['vat_number'] !== ''
                ? (string) $attributes['vat_number']
                : null,
            isset($attributes['tax_refnumber']) && $attributes['tax_refnumber'] !== ''
                ? (string) $attributes['tax_refnumber']
                : null,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'vat_number' => $this->vatNumber,
            'tax_refnumber' => $this->taxRefnumber,
        ];
    }
}
