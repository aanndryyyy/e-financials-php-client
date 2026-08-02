<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Bank;

/**
 * OpenAPI `BankAccounts` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class BankAccountResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 16,
        'account_name_est' => 'Swedbank AS EE123456780012345678',
        'account_name_eng' => 'Swedbank AS EE123456780012345678',
        'account_no' => 'EE123456780012345678',
        'cl_banks_id' => 1,
        'bank_name' => null,
        'bank_regcode' => null,
        'iban_code' => 'EE123456780012345678',
        'swift_code' => 'HABAEE2X',
        'start_sum' => null,
        'day_limit' => null,
        'credit_limit' => null,
        'show_in_sale_invoices' => true,
        'default_salary_account' => true,
        'beneficiary_name' => null,
        'accounts_dimensions_id' => 2,
        'clients_id' => 56,
    ];
}
