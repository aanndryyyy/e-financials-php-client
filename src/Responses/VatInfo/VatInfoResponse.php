<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\VatInfo;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
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
    use NormalizesAttributes;

    private function __construct(
        public readonly ?string $vatNumber,
        public readonly ?string $taxRefnumber,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::stringOrNull($attributes['vat_number'] ?? null),
            self::stringOrNull($attributes['tax_refnumber'] ?? null),
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
