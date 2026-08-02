<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Products;

/**
 * OpenAPI `Products` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class ProductResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 36166,
        'name' => 'printer HP',
        'foreign_names' => [],
        'cl_sale_articles_id' => 1,
        'sale_accounts_id' => 3100,
        'sale_accounts_dimensions_id' => null,
        'cl_purchase_articles_id' => null,
        'purchase_accounts_id' => null,
        'purchase_accounts_dimensions_id' => null,
        'code' => 'HP',
        'description' => null,
        'sales_price' => 170.0,
        'net_price' => null,
        'price_currency' => 'EUR',
        'notes' => null,
        'translations' => [
            'products__name__1' => '',
        ],
        'activity_text' => null,
        'emtak_code' => null,
        'emtak_version' => null,
        'unit' => 'tk',
        'amount' => null,
        'is_deleted' => false,
    ];
}
