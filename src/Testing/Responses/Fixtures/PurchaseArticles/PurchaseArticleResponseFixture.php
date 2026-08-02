<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\PurchaseArticles;

/**
 * OpenAPI `PurchaseArticles` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class PurchaseArticleResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 89,
        'level' => 2,
        'name_est' => 'Sisendkäibemaks, tollis impordilt tasutud',
        'name_eng' => 'Input VAT, customs paid on imports',
        'accounts_id' => 1510,
        'priority' => 15100,
        'cl_account_groups' => [
            'AR',
            'MTY',
            'SA',
        ],
        'is_disabled' => false,
    ];
}
