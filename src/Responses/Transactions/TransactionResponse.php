<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Transactions;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Transactions` schema, plus example-backed fields
 * (`is_deleted`, `operation_type`).
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one
 *
 * @phpstan-import-type TransactionItemData from TransactionItemResponse
 *
 * @phpstan-type TransactionData array{
 *     id: int|null,
 *     uploaded_files_id: int|null,
 *     accounts_id: int|null,
 *     accounts_dimensions_id: int|null,
 *     status: string|null,
 *     bank_accounts_id: int|null,
 *     bank_ref_number: string|null,
 *     bank_subtype: string|null,
 *     type: string|null,
 *     clients_id: int|null,
 *     bank_code: string|null,
 *     bank_account_no: string|null,
 *     bank_account_name: string|null,
 *     ref_number: string|null,
 *     amount: float|null,
 *     base_amount: float|null,
 *     currency_rate: float|null,
 *     cl_currencies_id: string|null,
 *     description: string|null,
 *     date: string|null,
 *     transactions_files_id: int|null,
 *     export_format: string|null,
 *     items: array<int, TransactionItemData>,
 *     is_deleted: bool|null,
 *     operation_type: string|null
 * }
 *
 * @implements ResponseContract<TransactionData>
 */
final class TransactionResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<TransactionData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, TransactionItemResponse>  $items
     */
    private function __construct(
        public readonly ?int $id,
        public readonly ?int $uploadedFilesId,
        public readonly ?int $accountsId,
        public readonly ?int $accountsDimensionsId,
        public readonly ?string $status,
        public readonly ?int $bankAccountsId,
        public readonly ?string $bankRefNumber,
        public readonly ?string $bankSubtype,
        public readonly ?string $type,
        public readonly ?int $clientsId,
        public readonly ?string $bankCode,
        public readonly ?string $bankAccountNo,
        public readonly ?string $bankAccountName,
        public readonly ?string $refNumber,
        public readonly ?float $amount,
        public readonly ?float $baseAmount,
        public readonly ?float $currencyRate,
        public readonly ?string $clCurrenciesId,
        public readonly ?string $description,
        public readonly ?string $date,
        public readonly ?int $transactionsFilesId,
        public readonly ?string $exportFormat,
        public readonly array $items,
        public readonly ?bool $isDeleted,
        public readonly ?string $operationType,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<int, array<string, mixed>> $rawItems */
        $rawItems = is_array($attributes['items'] ?? null) ? $attributes['items'] : [];

        $items = array_values(array_map(
            static fn (array $item): TransactionItemResponse => TransactionItemResponse::from($item),
            $rawItems,
        ));

        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['uploaded_files_id'] ?? null),
            self::intOrNull($attributes['accounts_id'] ?? null),
            self::intOrNull($attributes['accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['status'] ?? null),
            self::intOrNull($attributes['bank_accounts_id'] ?? null),
            self::stringOrNull($attributes['bank_ref_number'] ?? null),
            self::stringOrNull($attributes['bank_subtype'] ?? null),
            self::stringOrNull($attributes['type'] ?? null),
            self::intOrNull($attributes['clients_id'] ?? null),
            self::stringOrNull($attributes['bank_code'] ?? null),
            self::stringOrNull($attributes['bank_account_no'] ?? null),
            self::stringOrNull($attributes['bank_account_name'] ?? null),
            self::stringOrNull($attributes['ref_number'] ?? null),
            self::floatOrNull($attributes['amount'] ?? null),
            self::floatOrNull($attributes['base_amount'] ?? null),
            self::floatOrNull($attributes['currency_rate'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::stringOrNull($attributes['description'] ?? null),
            self::stringOrNull($attributes['date'] ?? null),
            self::intOrNull($attributes['transactions_files_id'] ?? null),
            self::stringOrNull($attributes['export_format'] ?? null),
            $items,
            self::boolOrNull($attributes['is_deleted'] ?? null),
            self::stringOrNull($attributes['operation_type'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'uploaded_files_id' => $this->uploadedFilesId,
            'accounts_id' => $this->accountsId,
            'accounts_dimensions_id' => $this->accountsDimensionsId,
            'status' => $this->status,
            'bank_accounts_id' => $this->bankAccountsId,
            'bank_ref_number' => $this->bankRefNumber,
            'bank_subtype' => $this->bankSubtype,
            'type' => $this->type,
            'clients_id' => $this->clientsId,
            'bank_code' => $this->bankCode,
            'bank_account_no' => $this->bankAccountNo,
            'bank_account_name' => $this->bankAccountName,
            'ref_number' => $this->refNumber,
            'amount' => $this->amount,
            'base_amount' => $this->baseAmount,
            'currency_rate' => $this->currencyRate,
            'cl_currencies_id' => $this->clCurrenciesId,
            'description' => $this->description,
            'date' => $this->date,
            'transactions_files_id' => $this->transactionsFilesId,
            'export_format' => $this->exportFormat,
            'items' => array_map(
                static fn (TransactionItemResponse $item): array => $item->toArray(),
                $this->items,
            ),
            'is_deleted' => $this->isDeleted,
            'operation_type' => $this->operationType,
        ];
    }
}
