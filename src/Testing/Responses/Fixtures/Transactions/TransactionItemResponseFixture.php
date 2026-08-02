<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Transactions;

/**
 * OpenAPI `TransactionsItems` schema projection.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class TransactionItemResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 1,
        'accounts_id' => 1010,
        'accounts_dimensions_id' => 4,
        'relation_table' => null,
        'relation_id' => null,
        'amount' => 2348.32,
        'base_amount' => 2348.32,
        'currency_rate' => 1.0,
        'cl_currencies_id' => 'EUR',
    ];
}
