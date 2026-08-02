<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\PurchaseInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `PurchaseInvoices` schema.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one
 *
 * @phpstan-import-type PurchaseInvoiceItemData from PurchaseInvoiceItemResponse
 *
 * @phpstan-type PurchaseInvoiceData array{
 *     id: int|null,
 *     base_document_files_id: int|null,
 *     bank_payment_orders_id: int|null,
 *     clients_id: int|null,
 *     client_name: string|null,
 *     number: string|null,
 *     create_date: string|null,
 *     journal_date: string|null,
 *     status: string|null,
 *     payment_status: string|null,
 *     net_price: float|null,
 *     vat_price: float|null,
 *     gross_price: float|null,
 *     payment_type: string|null,
 *     bank_ref_number: string|null,
 *     bank_account_no: string|null,
 *     term_days: int|null,
 *     overdue_charge: float|null,
 *     notes: string|null,
 *     paid_in_cash: bool|null,
 *     cash_accounts_id: int|null,
 *     cash_accounts_dimensions_id: int|null,
 *     liability_accounts_id: int|null,
 *     liability_accounts_dimensions_id: int|null,
 *     cl_currencies_id: string|null,
 *     currency_rate: float|null,
 *     base_net_price: float|null,
 *     base_vat_price: float|null,
 *     base_gross_price: float|null,
 *     cash_payment_date: string|null,
 *     subclients_id: int|null,
 *     is_xls_imported: bool|null,
 *     items: array<int, PurchaseInvoiceItemData>,
 *     journals: array<int, int>,
 *     settlements: array<int, int>,
 *     transactions: array<int, int>
 * }
 *
 * @implements ResponseContract<PurchaseInvoiceData>
 */
final class PurchaseInvoiceResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<PurchaseInvoiceData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, PurchaseInvoiceItemResponse>  $items
     * @param  array<int, int>  $journals
     * @param  array<int, int>  $settlements
     * @param  array<int, int>  $transactions
     */
    private function __construct(
        public readonly ?int $id,
        public readonly ?int $baseDocumentFilesId,
        public readonly ?int $bankPaymentOrdersId,
        public readonly ?int $clientsId,
        public readonly ?string $clientName,
        public readonly ?string $number,
        public readonly ?string $createDate,
        public readonly ?string $journalDate,
        public readonly ?string $status,
        public readonly ?string $paymentStatus,
        public readonly ?float $netPrice,
        public readonly ?float $vatPrice,
        public readonly ?float $grossPrice,
        public readonly ?string $paymentType,
        public readonly ?string $bankRefNumber,
        public readonly ?string $bankAccountNo,
        public readonly ?int $termDays,
        public readonly ?float $overdueCharge,
        public readonly ?string $notes,
        public readonly ?bool $paidInCash,
        public readonly ?int $cashAccountsId,
        public readonly ?int $cashAccountsDimensionsId,
        public readonly ?int $liabilityAccountsId,
        public readonly ?int $liabilityAccountsDimensionsId,
        public readonly ?string $clCurrenciesId,
        public readonly ?float $currencyRate,
        public readonly ?float $baseNetPrice,
        public readonly ?float $baseVatPrice,
        public readonly ?float $baseGrossPrice,
        public readonly ?string $cashPaymentDate,
        public readonly ?int $subclientsId,
        public readonly ?bool $isXlsImported,
        public readonly array $items,
        public readonly array $journals,
        public readonly array $settlements,
        public readonly array $transactions,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<int, array<string, mixed>> $rawItems */
        $rawItems = is_array($attributes['items'] ?? null) ? $attributes['items'] : [];

        $items = array_values(array_map(
            static fn (array $item): PurchaseInvoiceItemResponse => PurchaseInvoiceItemResponse::from($item),
            $rawItems,
        ));

        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['base_document_files_id'] ?? null),
            self::intOrNull($attributes['bank_payment_orders_id'] ?? null),
            self::intOrNull($attributes['clients_id'] ?? null),
            self::stringOrNull($attributes['client_name'] ?? null),
            self::stringOrNull($attributes['number'] ?? null),
            self::stringOrNull($attributes['create_date'] ?? null),
            self::stringOrNull($attributes['journal_date'] ?? null),
            self::stringOrNull($attributes['status'] ?? null),
            self::stringOrNull($attributes['payment_status'] ?? null),
            self::floatOrNull($attributes['net_price'] ?? null),
            self::floatOrNull($attributes['vat_price'] ?? null),
            self::floatOrNull($attributes['gross_price'] ?? null),
            self::stringOrNull($attributes['payment_type'] ?? null),
            self::stringOrNull($attributes['bank_ref_number'] ?? null),
            self::stringOrNull($attributes['bank_account_no'] ?? null),
            self::intOrNull($attributes['term_days'] ?? null),
            self::floatOrNull($attributes['overdue_charge'] ?? null),
            self::stringOrNull($attributes['notes'] ?? null),
            self::boolOrNull($attributes['paid_in_cash'] ?? null),
            self::intOrNull($attributes['cash_accounts_id'] ?? null),
            self::intOrNull($attributes['cash_accounts_dimensions_id'] ?? null),
            self::intOrNull($attributes['liability_accounts_id'] ?? null),
            self::intOrNull($attributes['liability_accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::floatOrNull($attributes['currency_rate'] ?? null),
            self::floatOrNull($attributes['base_net_price'] ?? null),
            self::floatOrNull($attributes['base_vat_price'] ?? null),
            self::floatOrNull($attributes['base_gross_price'] ?? null),
            self::stringOrNull($attributes['cash_payment_date'] ?? null),
            self::intOrNull($attributes['subclients_id'] ?? null),
            self::boolOrNull($attributes['is_xls_imported'] ?? null),
            $items,
            self::intList($attributes['journals'] ?? null),
            self::intList($attributes['settlements'] ?? null),
            self::intList($attributes['transactions'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'base_document_files_id' => $this->baseDocumentFilesId,
            'bank_payment_orders_id' => $this->bankPaymentOrdersId,
            'clients_id' => $this->clientsId,
            'client_name' => $this->clientName,
            'number' => $this->number,
            'create_date' => $this->createDate,
            'journal_date' => $this->journalDate,
            'status' => $this->status,
            'payment_status' => $this->paymentStatus,
            'net_price' => $this->netPrice,
            'vat_price' => $this->vatPrice,
            'gross_price' => $this->grossPrice,
            'payment_type' => $this->paymentType,
            'bank_ref_number' => $this->bankRefNumber,
            'bank_account_no' => $this->bankAccountNo,
            'term_days' => $this->termDays,
            'overdue_charge' => $this->overdueCharge,
            'notes' => $this->notes,
            'paid_in_cash' => $this->paidInCash,
            'cash_accounts_id' => $this->cashAccountsId,
            'cash_accounts_dimensions_id' => $this->cashAccountsDimensionsId,
            'liability_accounts_id' => $this->liabilityAccountsId,
            'liability_accounts_dimensions_id' => $this->liabilityAccountsDimensionsId,
            'cl_currencies_id' => $this->clCurrenciesId,
            'currency_rate' => $this->currencyRate,
            'base_net_price' => $this->baseNetPrice,
            'base_vat_price' => $this->baseVatPrice,
            'base_gross_price' => $this->baseGrossPrice,
            'cash_payment_date' => $this->cashPaymentDate,
            'subclients_id' => $this->subclientsId,
            'is_xls_imported' => $this->isXlsImported,
            'items' => array_map(
                static fn (PurchaseInvoiceItemResponse $item): array => $item->toArray(),
                $this->items,
            ),
            'journals' => $this->journals,
            'settlements' => $this->settlements,
            'transactions' => $this->transactions,
        ];
    }
}
