<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\SalesInvoices;

/**
 * OpenAPI `SaleInvoicesItems` schema projection.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class SaleInvoiceItemResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 42,
        'products_id' => 36166,
        'cl_sale_articles_id' => 1,
        'sale_accounts_id' => 3100,
        'sale_accounts_dimensions_id' => null,
        'amount' => 1.0,
        'unit' => 'tk',
        'unit_net_price' => 40608.0,
        'total_net_price' => 40608.0,
        'base_total_net_price' => 40608.0,
        'vat_accounts_id' => null,
        'vat_rate' => 20.0,
        'discount_percent' => null,
        'discount_amount' => null,
        'custom_title' => 'Consulting',
        'projects_project_id' => null,
        'projects_location_id' => null,
        'projects_person_id' => null,
        'vat_amount' => 8121.6,
    ];
}
