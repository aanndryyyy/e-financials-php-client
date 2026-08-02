<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\PurchaseInvoices;

/**
 * OpenAPI `PurchaseInvoices` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class PurchaseInvoiceResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 1983,
        'base_document_files_id' => null,
        'bank_payment_orders_id' => null,
        'clients_id' => 803,
        'client_name' => 'Aktsiaselts Kaupmees & Ko',
        'number' => '234234',
        'create_date' => '2017-08-09',
        'journal_date' => '2017-08-09',
        'status' => 'CONFIRMED',
        'payment_status' => 'PAID',
        'net_price' => 0.0,
        'vat_price' => 0.0,
        'gross_price' => 0.0,
        'payment_type' => null,
        'bank_ref_number' => null,
        'bank_account_no' => null,
        'term_days' => 0,
        'overdue_charge' => null,
        'notes' => null,
        'paid_in_cash' => false,
        'cash_accounts_id' => null,
        'cash_accounts_dimensions_id' => null,
        'liability_accounts_id' => 2310,
        'liability_accounts_dimensions_id' => null,
        'cl_currencies_id' => 'EUR',
        'currency_rate' => 1.0,
        'base_net_price' => 0.0,
        'base_vat_price' => 0.0,
        'base_gross_price' => 0.0,
        'cash_payment_date' => null,
        'subclients_id' => null,
        'is_xls_imported' => false,
        'items' => [
            PurchaseInvoiceItemResponseFixture::ATTRIBUTES,
        ],
        'journals' => [],
        'settlements' => [],
        'transactions' => [],
    ];
}
