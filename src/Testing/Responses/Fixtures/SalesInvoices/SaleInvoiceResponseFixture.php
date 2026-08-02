<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\SalesInvoices;

/**
 * OpenAPI `SaleInvoices` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class SaleInvoiceResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 1698,
        'credit_sale_invoices_id' => null,
        'credit_invoice_payment_type' => null,
        'sale_invoice_type' => 'INVOICE',
        'cl_templates_id' => 1,
        'clients_id' => 126,
        'client_name' => 'PAypal',
        'cl_countries_id' => 'EST',
        'number_prefix' => 'NX',
        'number_suffix' => '91',
        'number' => 'NX91',
        'create_date' => '2016-02-15',
        'journal_date' => '2016-02-15',
        'status' => 'CONFIRMED',
        'payment_status' => null,
        'net_price' => 40608.0,
        'vat5_price' => 0.0,
        'vat9_price' => 0.0,
        'vat20_price' => 8121.6,
        'gross_price' => 48729.6,
        'bank_ref_number' => '116758',
        'term_days' => 30,
        'overdue_charge' => 0.15,
        'notes' => null,
        'base_document_files_id' => null,
        'files_id' => 3419,
        'is_doubtful' => false,
        'is_hopeless' => false,
        'use_per_item_rounding' => false,
        'paid_in_cash' => false,
        'cash_accounts_id' => null,
        'cash_accounts_dimensions_id' => null,
        'invoice_info' => null,
        'payment_description' => null,
        'cl_currencies_id' => 'EUR',
        'currency_rate' => 1.0,
        'base_gross_price' => 48729.6,
        'base_net_price' => 40608.0,
        'base_vat5_price' => 0.0,
        'base_vat9_price' => 0.0,
        'base_vat20_price' => 8121.6,
        'cash_payment_date' => null,
        'trade_secret' => false,
        'receivable_accounts_id' => 1210,
        'receivable_accounts_dimensions_id' => null,
        'intra_community_supply' => false,
        'client_vat_no' => null,
        'triangulation' => false,
        'assembled_in_member_state' => false,
        'show_client_balance' => false,
        'subclients_id' => null,
        'is_xls_imported' => false,
        'recipient_clients_id' => null,
        'recipient_subclients_id' => null,
        'contract_number' => null,
        'invoice_content_code' => null,
        'invoice_content_text' => null,
        'period_start_date' => null,
        'period_end_date' => null,
        'additional_info_content' => null,
        'bank_payment_orders_id' => null,
        'bank_accounts_id' => null,
        'triangulation_seller_invoice_vat_no' => null,
        'items' => [
            SaleInvoiceItemResponseFixture::ATTRIBUTES,
        ],
        'deliveries' => [
            SaleInvoiceDeliveryResponseFixture::ATTRIBUTES,
        ],
        'credit_invoices' => [],
        'journals' => [],
        'settlements' => [],
        'transactions' => [],
    ];
}
