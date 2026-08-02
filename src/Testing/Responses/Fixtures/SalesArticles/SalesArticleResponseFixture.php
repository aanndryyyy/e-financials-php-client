<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\SalesArticles;

/**
 * OpenAPI `SaleArticles` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class SalesArticleResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 34,
        'group_est' => 'Pandipakendid',
        'group_eng' => 'Pledge packages',
        'name_est' => 'Pandipakendid',
        'name_eng' => 'Pledge packages',
        'accounts_id' => 1615,
        'vat_accounts_id' => null,
        'vat_rate' => null,
        'vat_type' => 0,
        'is_valid' => true,
        'start_date' => null,
        'end_date' => null,
        'priority' => 15,
        'cl_account_groups' => [
            'AR',
            'MTY',
            'SA',
        ],
        'description_est' => null,
        'description_eng' => null,
    ];
}
