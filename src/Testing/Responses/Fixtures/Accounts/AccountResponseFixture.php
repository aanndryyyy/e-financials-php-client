<?php

declare(strict_types=1);

namespace EFinancialsClient\Testing\Responses\Fixtures\Accounts;

/**
 * OpenAPI `Accounts` schema example (fuller projection).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 */
final class AccountResponseFixture
{
    /**
     * @var array<string, mixed>
     */
    public const ATTRIBUTES = [
        'id' => 1010,
        'balance_type' => 'D',
        'account_type_est' => 'Varad',
        'account_type_eng' => 'Assets',
        'name_est' => 'Sularaha kassas',
        'name_eng' => 'Cash on hand',
        'is_valid' => true,
        'allows_deactivation' => false,
        'is_vat_account' => false,
        'is_fixed_asset' => false,
        'expenditure_accounts_id' => null,
        'amortization_accounts_id' => null,
        'transaction_in_bindable' => true,
        'transaction_out_bindable' => true,
        'priority' => 1010,
        'cl_account_groups' => [
            'AR',
            'MTY',
            'SA',
        ],
        'default_disabled' => false,
        'transaction_in_user_bindable' => false,
        'transaction_out_user_bindable' => false,
        'is_product_account' => false,
        'allows_dimensions' => true,
        'requires_client' => false,
        'requires_positive_balance' => false,
        'is_disabled' => false,
        'transaction_in_user_bindable_set' => false,
        'transaction_out_user_bindable_set' => false,
    ];
}
