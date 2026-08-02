<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Invoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `InvoiceSeries` schema.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_series_one
 *
 * @phpstan-type InvoiceSeriesData array{
 *     id: int|null,
 *     is_active: bool,
 *     is_default: bool,
 *     number_prefix: string,
 *     number_start_value: int,
 *     term_days: int,
 *     overdue_charge: float|null
 * }
 *
 * @implements ResponseContract<InvoiceSeriesData>
 */
final class InvoiceSeriesResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<InvoiceSeriesData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly bool $isActive,
        public readonly bool $isDefault,
        public readonly string $numberPrefix,
        public readonly int $numberStartValue,
        public readonly int $termDays,
        public readonly ?float $overdueCharge,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::boolValue($attributes['is_active'] ?? null),
            self::boolValue($attributes['is_default'] ?? null),
            self::stringValue($attributes['number_prefix'] ?? null),
            self::intValue($attributes['number_start_value'] ?? null),
            self::intValue($attributes['term_days'] ?? null),
            self::floatOrNull($attributes['overdue_charge'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'is_active' => $this->isActive,
            'is_default' => $this->isDefault,
            'number_prefix' => $this->numberPrefix,
            'number_start_value' => $this->numberStartValue,
            'term_days' => $this->termDays,
            'overdue_charge' => $this->overdueCharge,
        ];
    }
}
