<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Invoices;

/**
 * OpenAPI `InvoiceSeries` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class InvoiceSeriesResponseFixture
{
    /**
     * @var array{
     *     id: int,
     *     is_active: bool,
     *     is_default: bool,
     *     number_prefix: string,
     *     number_start_value: int,
     *     overdue_charge: float,
     *     term_days: int
     * }
     */
    public const ATTRIBUTES = [
        'id' => 3,
        'is_active' => true,
        'is_default' => false,
        'number_prefix' => 'NX',
        'number_start_value' => 1,
        'overdue_charge' => 0.15,
        'term_days' => 28,
    ];
}
