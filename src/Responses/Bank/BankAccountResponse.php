<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Bank;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `BankAccounts` schema
 * (plus selected example-backed fields omitted from `properties`).
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type BankAccountData array{
 *     id: int|null,
 *     account_name_est: string,
 *     account_name_eng: string|null,
 *     account_no: string,
 *     cl_banks_id: int|null,
 *     bank_name: string|null,
 *     bank_regcode: string|null,
 *     iban_code: string|null,
 *     swift_code: string|null,
 *     start_sum: float|null,
 *     day_limit: float|null,
 *     credit_limit: float|null,
 *     show_in_sale_invoices: bool|null,
 *     default_salary_account: bool|null,
 *     beneficiary_name: string|null,
 *     accounts_dimensions_id: int|null,
 *     clients_id: int|null
 * }
 *
 * @implements ResponseContract<BankAccountData>
 */
final class BankAccountResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<BankAccountData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?int $id,
        public readonly string $accountNameEst,
        public readonly ?string $accountNameEng,
        public readonly string $accountNo,
        public readonly ?int $clBanksId,
        public readonly ?string $bankName,
        public readonly ?string $bankRegcode,
        public readonly ?string $ibanCode,
        public readonly ?string $swiftCode,
        public readonly ?float $startSum,
        public readonly ?float $dayLimit,
        public readonly ?float $creditLimit,
        public readonly ?bool $showInSaleInvoices,
        public readonly ?bool $defaultSalaryAccount,
        public readonly ?string $beneficiaryName,
        public readonly ?int $accountsDimensionsId,
        public readonly ?int $clientsId,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::stringValue($attributes['account_name_est'] ?? null),
            self::stringOrNull($attributes['account_name_eng'] ?? null),
            self::stringValue($attributes['account_no'] ?? null),
            self::intOrNull($attributes['cl_banks_id'] ?? null),
            self::stringOrNull($attributes['bank_name'] ?? null),
            self::stringOrNull($attributes['bank_regcode'] ?? null),
            self::stringOrNull($attributes['iban_code'] ?? null),
            self::stringOrNull($attributes['swift_code'] ?? null),
            self::floatOrNull($attributes['start_sum'] ?? null),
            self::floatOrNull($attributes['day_limit'] ?? null),
            self::floatOrNull($attributes['credit_limit'] ?? null),
            self::boolOrNull($attributes['show_in_sale_invoices'] ?? null),
            self::boolOrNull($attributes['default_salary_account'] ?? null),
            self::stringOrNull($attributes['beneficiary_name'] ?? null),
            self::intOrNull($attributes['accounts_dimensions_id'] ?? null),
            self::intOrNull($attributes['clients_id'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'account_name_est' => $this->accountNameEst,
            'account_name_eng' => $this->accountNameEng,
            'account_no' => $this->accountNo,
            'cl_banks_id' => $this->clBanksId,
            'bank_name' => $this->bankName,
            'bank_regcode' => $this->bankRegcode,
            'iban_code' => $this->ibanCode,
            'swift_code' => $this->swiftCode,
            'start_sum' => $this->startSum,
            'day_limit' => $this->dayLimit,
            'credit_limit' => $this->creditLimit,
            'show_in_sale_invoices' => $this->showInSaleInvoices,
            'default_salary_account' => $this->defaultSalaryAccount,
            'beneficiary_name' => $this->beneficiaryName,
            'accounts_dimensions_id' => $this->accountsDimensionsId,
            'clients_id' => $this->clientsId,
        ];
    }
}
