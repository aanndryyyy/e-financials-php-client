<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Transactions;

/**
 * OpenAPI `Transactions` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class TransactionResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 2672,
        'uploaded_files_id' => null,
        'accounts_id' => 1010,
        'accounts_dimensions_id' => 4,
        'status' => 'CONFIRMED',
        'bank_accounts_id' => null,
        'bank_ref_number' => null,
        'bank_subtype' => null,
        'type' => 'D',
        'clients_id' => 19,
        'bank_code' => null,
        'bank_account_no' => null,
        'bank_account_name' => null,
        'ref_number' => null,
        'amount' => 2348.32,
        'base_amount' => 2348.32,
        'currency_rate' => 1.0,
        'cl_currencies_id' => 'EUR',
        'description' => 'Töötasu väljamakse nr 10069 (Bob Smith 01.2015) tasumine sularahas',
        'date' => '2015-01-31',
        'transactions_files_id' => null,
        'export_format' => null,
        'items' => [],
        'is_deleted' => false,
        'operation_type' => null,
    ];
}
