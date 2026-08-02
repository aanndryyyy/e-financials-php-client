<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\SalesInvoices;

/**
 * OpenAPI `SaleInvoicesDeliveryOptions` schema projection.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class SaleInvoiceDeliveryOptionsResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'can_send_einvoice' => false,
        'can_send_einvoice_reason' => 'Missing e-invoice address',
        'can_send_email' => true,
        'can_send_email_addresses' => 'test@mail.ee',
    ];
}
