<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Accounts;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Accounts` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type AccountData array{
 *     id: int|null,
 *     balance_type: string,
 *     account_type_est: string,
 *     account_type_eng: string,
 *     name_est: string,
 *     name_eng: string,
 *     is_valid: bool,
 *     allows_deactivation: bool,
 *     is_vat_account: bool,
 *     is_fixed_asset: bool,
 *     expenditure_accounts_id: int|null,
 *     amortization_accounts_id: int|null,
 *     transaction_in_bindable: bool,
 *     transaction_out_bindable: bool,
 *     priority: int|null,
 *     cl_account_groups: array<int, string>,
 *     default_disabled: bool,
 *     transaction_in_user_bindable: bool,
 *     transaction_out_user_bindable: bool,
 *     is_product_account: bool,
 *     allows_dimensions: bool|null,
 *     requires_client: bool|null,
 *     requires_positive_balance: bool|null,
 *     is_disabled: bool|null,
 *     transaction_in_user_bindable_set: bool|null,
 *     transaction_out_user_bindable_set: bool|null
 * }
 *
 * @implements ResponseContract<AccountData>
 */
final class AccountResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<AccountData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, string>  $clAccountGroups
     */
    private function __construct(
        public readonly ?int $id,
        public readonly string $balanceType,
        public readonly string $accountTypeEst,
        public readonly string $accountTypeEng,
        public readonly string $nameEst,
        public readonly string $nameEng,
        public readonly bool $isValid,
        public readonly bool $allowsDeactivation,
        public readonly bool $isVatAccount,
        public readonly bool $isFixedAsset,
        public readonly ?int $expenditureAccountsId,
        public readonly ?int $amortizationAccountsId,
        public readonly bool $transactionInBindable,
        public readonly bool $transactionOutBindable,
        public readonly ?int $priority,
        public readonly array $clAccountGroups,
        public readonly bool $defaultDisabled,
        public readonly bool $transactionInUserBindable,
        public readonly bool $transactionOutUserBindable,
        public readonly bool $isProductAccount,
        public readonly ?bool $allowsDimensions,
        public readonly ?bool $requiresClient,
        public readonly ?bool $requiresPositiveBalance,
        public readonly ?bool $isDisabled,
        public readonly ?bool $transactionInUserBindableSet,
        public readonly ?bool $transactionOutUserBindableSet,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::stringValue($attributes['balance_type'] ?? null),
            self::stringValue($attributes['account_type_est'] ?? null),
            self::stringValue($attributes['account_type_eng'] ?? null),
            self::stringValue($attributes['name_est'] ?? null),
            self::stringValue($attributes['name_eng'] ?? null),
            self::boolValue($attributes['is_valid'] ?? null),
            self::boolValue($attributes['allows_deactivation'] ?? null),
            self::boolValue($attributes['is_vat_account'] ?? null),
            self::boolValue($attributes['is_fixed_asset'] ?? null),
            self::intOrNull($attributes['expenditure_accounts_id'] ?? null),
            self::intOrNull($attributes['amortization_accounts_id'] ?? null),
            self::boolValue($attributes['transaction_in_bindable'] ?? null),
            self::boolValue($attributes['transaction_out_bindable'] ?? null),
            self::intOrNull($attributes['priority'] ?? null),
            self::stringList($attributes['cl_account_groups'] ?? null),
            self::boolValue($attributes['default_disabled'] ?? null),
            self::boolValue($attributes['transaction_in_user_bindable'] ?? null),
            self::boolValue($attributes['transaction_out_user_bindable'] ?? null),
            self::boolValue($attributes['is_product_account'] ?? null),
            self::boolOrNull($attributes['allows_dimensions'] ?? null),
            self::boolOrNull($attributes['requires_client'] ?? null),
            self::boolOrNull($attributes['requires_positive_balance'] ?? null),
            self::boolOrNull($attributes['is_disabled'] ?? null),
            self::boolOrNull($attributes['transaction_in_user_bindable_set'] ?? null),
            self::boolOrNull($attributes['transaction_out_user_bindable_set'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'balance_type' => $this->balanceType,
            'account_type_est' => $this->accountTypeEst,
            'account_type_eng' => $this->accountTypeEng,
            'name_est' => $this->nameEst,
            'name_eng' => $this->nameEng,
            'is_valid' => $this->isValid,
            'allows_deactivation' => $this->allowsDeactivation,
            'is_vat_account' => $this->isVatAccount,
            'is_fixed_asset' => $this->isFixedAsset,
            'expenditure_accounts_id' => $this->expenditureAccountsId,
            'amortization_accounts_id' => $this->amortizationAccountsId,
            'transaction_in_bindable' => $this->transactionInBindable,
            'transaction_out_bindable' => $this->transactionOutBindable,
            'priority' => $this->priority,
            'cl_account_groups' => $this->clAccountGroups,
            'default_disabled' => $this->defaultDisabled,
            'transaction_in_user_bindable' => $this->transactionInUserBindable,
            'transaction_out_user_bindable' => $this->transactionOutUserBindable,
            'is_product_account' => $this->isProductAccount,
            'allows_dimensions' => $this->allowsDimensions,
            'requires_client' => $this->requiresClient,
            'requires_positive_balance' => $this->requiresPositiveBalance,
            'is_disabled' => $this->isDisabled,
            'transaction_in_user_bindable_set' => $this->transactionInUserBindableSet,
            'transaction_out_user_bindable_set' => $this->transactionOutUserBindableSet,
        ];
    }
}
