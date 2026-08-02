<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\PurchaseInvoices;

/**
 * OpenAPI `PurchaseInvoicesItems` schema projection.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class PurchaseInvoiceItemResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 10,
        'cl_purchase_articles_id' => 1,
        'purchase_accounts_id' => 4010,
        'purchase_accounts_dimensions_id' => null,
        'cl_fringe_benefits_id' => null,
        'amount' => 1.0,
        'unit' => 'tk',
        'unit_net_price' => 100.0,
        'total_net_price' => 100.0,
        'base_total_net_price' => 100.0,
        'cl_vat_articles_id' => 1,
        'vat_accounts_id' => null,
        'vat_accounts_dimensions_id' => null,
        'vat_rate_dropdown' => '20',
        'vat_rate' => 20.0,
        'custom_title' => 'Office supplies',
        'projects_project_id' => null,
        'projects_location_id' => null,
        'projects_person_id' => null,
        'reversed_vat_id' => null,
        'products_id' => null,
        'project_no_vat_gross_price' => null,
    ];
}
