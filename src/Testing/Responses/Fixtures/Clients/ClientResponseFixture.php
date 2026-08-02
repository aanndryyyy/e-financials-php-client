<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Clients;

/**
 * OpenAPI `Clients` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class ClientResponseFixture
{
    /**
     * @var array{
     *     accounting_email: null,
     *     address_adr_id: null,
     *     address_ads_oid: null,
     *     address_text: null,
     *     alt_name: null,
     *     bank_account_custom_name: null,
     *     bank_account_no: null,
     *     bank_ref_number_purchases: null,
     *     bank_ref_number_sales: null,
     *     cl_code_country: string,
     *     cl_invoice_country: string,
     *     cl_purchase_articles_id: null,
     *     code: string,
     *     contact_person: null,
     *     email: null,
     *     id: int,
     *     invoice_days: null,
     *     invoice_electronic_opts: array{},
     *     invoice_overdue_charge: null,
     *     invoice_vat_no: null,
     *     is_associate_company: bool,
     *     is_client: bool,
     *     is_deleted: bool,
     *     is_juridical_entity: bool,
     *     is_member: bool,
     *     is_parent_company_group: bool,
     *     is_physical_entity: bool,
     *     is_related_party: bool,
     *     is_staff: bool,
     *     is_supplier: bool,
     *     name: string,
     *     notes: null,
     *     postal_address_text: null,
     *     purchase_accounts_dimensions_id: null,
     *     purchase_accounts_id: null,
     *     send_invoice_to_accounting_email: bool,
     *     send_invoice_to_email: bool,
     *     telephone: null
     * }
     */
    public const ATTRIBUTES = [
        'accounting_email' => null,
        'address_adr_id' => null,
        'address_ads_oid' => null,
        'address_text' => null,
        'alt_name' => null,
        'bank_account_custom_name' => null,
        'bank_account_no' => null,
        'bank_ref_number_purchases' => null,
        'bank_ref_number_sales' => null,
        'cl_code_country' => 'EST',
        'cl_invoice_country' => 'EST',
        'cl_purchase_articles_id' => null,
        'code' => '14168677',
        'contact_person' => null,
        'email' => null,
        'id' => 1916,
        'invoice_days' => null,
        'invoice_electronic_opts' => [],
        'invoice_overdue_charge' => null,
        'invoice_vat_no' => null,
        'is_associate_company' => false,
        'is_client' => true,
        'is_deleted' => true,
        'is_juridical_entity' => true,
        'is_member' => false,
        'is_parent_company_group' => false,
        'is_physical_entity' => false,
        'is_related_party' => false,
        'is_staff' => false,
        'is_supplier' => true,
        'name' => 'A24 Laen OÜ',
        'notes' => null,
        'postal_address_text' => null,
        'purchase_accounts_dimensions_id' => null,
        'purchase_accounts_id' => null,
        'send_invoice_to_accounting_email' => false,
        'send_invoice_to_email' => false,
        'telephone' => null,
    ];
}
