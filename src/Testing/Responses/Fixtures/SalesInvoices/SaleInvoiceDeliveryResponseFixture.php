<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\SalesInvoices;

/**
 * OpenAPI `SaleInvoicesDeliveries` schema projection.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class SaleInvoiceDeliveryResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'create_date' => '2016-02-16T10:00:00',
        'destination_type' => 'EMAIL',
        'invoice_type' => 'PDF',
        'receiver_address' => 'test@mail.ee',
        'receiver_name' => 'PAypal',
        'send_method' => 1,
        'sender_person_code' => null,
        'sender_person_name' => null,
        'status_date' => '2016-02-16T10:00:00',
        'transfer_status_code' => 0,
    ];
}
