<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `SaleInvoices` schema, plus example-backed fields
 * (`bank_accounts_id`, `triangulation_seller_invoice_vat_no`).
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one
 *
 * @phpstan-import-type SaleInvoiceItemData from SaleInvoiceItemResponse
 * @phpstan-import-type SaleInvoiceDeliveryData from SaleInvoiceDeliveryResponse
 *
 * @phpstan-type SaleInvoiceData array{
 *     id: int|null,
 *     credit_sale_invoices_id: int|null,
 *     credit_invoice_payment_type: string|null,
 *     sale_invoice_type: string|null,
 *     cl_templates_id: int|null,
 *     clients_id: int|null,
 *     client_name: string|null,
 *     cl_countries_id: string|null,
 *     number_prefix: string|null,
 *     number_suffix: string|null,
 *     number: string|null,
 *     create_date: string|null,
 *     journal_date: string|null,
 *     status: string|null,
 *     payment_status: string|null,
 *     net_price: float|null,
 *     vat5_price: float|null,
 *     vat9_price: float|null,
 *     vat20_price: float|null,
 *     gross_price: float|null,
 *     bank_ref_number: string|null,
 *     term_days: int|null,
 *     overdue_charge: float|null,
 *     notes: string|null,
 *     base_document_files_id: int|null,
 *     files_id: int|null,
 *     is_doubtful: bool|null,
 *     is_hopeless: bool|null,
 *     use_per_item_rounding: bool|null,
 *     paid_in_cash: bool|null,
 *     cash_accounts_id: int|null,
 *     cash_accounts_dimensions_id: int|null,
 *     invoice_info: string|null,
 *     payment_description: string|null,
 *     cl_currencies_id: string|null,
 *     currency_rate: float|null,
 *     base_gross_price: float|null,
 *     base_net_price: float|null,
 *     base_vat5_price: float|null,
 *     base_vat9_price: float|null,
 *     base_vat20_price: float|null,
 *     cash_payment_date: string|null,
 *     trade_secret: bool|null,
 *     receivable_accounts_id: int|null,
 *     receivable_accounts_dimensions_id: int|null,
 *     intra_community_supply: bool|null,
 *     client_vat_no: string|null,
 *     triangulation: bool|null,
 *     assembled_in_member_state: bool|null,
 *     show_client_balance: bool|null,
 *     subclients_id: int|null,
 *     is_xls_imported: bool|null,
 *     recipient_clients_id: int|null,
 *     recipient_subclients_id: int|null,
 *     contract_number: string|null,
 *     invoice_content_code: string|null,
 *     invoice_content_text: string|null,
 *     period_start_date: string|null,
 *     period_end_date: string|null,
 *     additional_info_content: string|null,
 *     bank_payment_orders_id: int|null,
 *     bank_accounts_id: int|null,
 *     triangulation_seller_invoice_vat_no: string|null,
 *     items: array<int, SaleInvoiceItemData>,
 *     deliveries: array<int, SaleInvoiceDeliveryData>,
 *     credit_invoices: array<int, int>,
 *     journals: array<int, int>,
 *     settlements: array<int, int>,
 *     transactions: array<int, int>
 * }
 *
 * @implements ResponseContract<SaleInvoiceData>
 */
final class SaleInvoiceResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<SaleInvoiceData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    /**
     * @param  array<int, SaleInvoiceItemResponse>  $items
     * @param  array<int, SaleInvoiceDeliveryResponse>  $deliveries
     * @param  array<int, int>  $creditInvoices
     * @param  array<int, int>  $journals
     * @param  array<int, int>  $settlements
     * @param  array<int, int>  $transactions
     */
    private function __construct(
        public readonly ?int $id,
        public readonly ?int $creditSaleInvoicesId,
        public readonly ?string $creditInvoicePaymentType,
        public readonly ?string $saleInvoiceType,
        public readonly ?int $clTemplatesId,
        public readonly ?int $clientsId,
        public readonly ?string $clientName,
        public readonly ?string $clCountriesId,
        public readonly ?string $numberPrefix,
        public readonly ?string $numberSuffix,
        public readonly ?string $number,
        public readonly ?string $createDate,
        public readonly ?string $journalDate,
        public readonly ?string $status,
        public readonly ?string $paymentStatus,
        public readonly ?float $netPrice,
        public readonly ?float $vat5Price,
        public readonly ?float $vat9Price,
        public readonly ?float $vat20Price,
        public readonly ?float $grossPrice,
        public readonly ?string $bankRefNumber,
        public readonly ?int $termDays,
        public readonly ?float $overdueCharge,
        public readonly ?string $notes,
        public readonly ?int $baseDocumentFilesId,
        public readonly ?int $filesId,
        public readonly ?bool $isDoubtful,
        public readonly ?bool $isHopeless,
        public readonly ?bool $usePerItemRounding,
        public readonly ?bool $paidInCash,
        public readonly ?int $cashAccountsId,
        public readonly ?int $cashAccountsDimensionsId,
        public readonly ?string $invoiceInfo,
        public readonly ?string $paymentDescription,
        public readonly ?string $clCurrenciesId,
        public readonly ?float $currencyRate,
        public readonly ?float $baseGrossPrice,
        public readonly ?float $baseNetPrice,
        public readonly ?float $baseVat5Price,
        public readonly ?float $baseVat9Price,
        public readonly ?float $baseVat20Price,
        public readonly ?string $cashPaymentDate,
        public readonly ?bool $tradeSecret,
        public readonly ?int $receivableAccountsId,
        public readonly ?int $receivableAccountsDimensionsId,
        public readonly ?bool $intraCommunitySupply,
        public readonly ?string $clientVatNo,
        public readonly ?bool $triangulation,
        public readonly ?bool $assembledInMemberState,
        public readonly ?bool $showClientBalance,
        public readonly ?int $subclientsId,
        public readonly ?bool $isXlsImported,
        public readonly ?int $recipientClientsId,
        public readonly ?int $recipientSubclientsId,
        public readonly ?string $contractNumber,
        public readonly ?string $invoiceContentCode,
        public readonly ?string $invoiceContentText,
        public readonly ?string $periodStartDate,
        public readonly ?string $periodEndDate,
        public readonly ?string $additionalInfoContent,
        public readonly ?int $bankPaymentOrdersId,
        public readonly ?int $bankAccountsId,
        public readonly ?string $triangulationSellerInvoiceVatNo,
        public readonly array $items,
        public readonly array $deliveries,
        public readonly array $creditInvoices,
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
            static fn (array $item): SaleInvoiceItemResponse => SaleInvoiceItemResponse::from($item),
            $rawItems,
        ));

        /** @var array<int, array<string, mixed>> $rawDeliveries */
        $rawDeliveries = is_array($attributes['deliveries'] ?? null) ? $attributes['deliveries'] : [];
        $deliveries = array_values(array_map(
            static fn (array $delivery): SaleInvoiceDeliveryResponse => SaleInvoiceDeliveryResponse::from($delivery),
            $rawDeliveries,
        ));

        return new self(
            self::intOrNull($attributes['id'] ?? null),
            self::intOrNull($attributes['credit_sale_invoices_id'] ?? null),
            self::stringOrNull($attributes['credit_invoice_payment_type'] ?? null),
            self::stringOrNull($attributes['sale_invoice_type'] ?? null),
            self::intOrNull($attributes['cl_templates_id'] ?? null),
            self::intOrNull($attributes['clients_id'] ?? null),
            self::stringOrNull($attributes['client_name'] ?? null),
            self::stringOrNull($attributes['cl_countries_id'] ?? null),
            self::stringOrNull($attributes['number_prefix'] ?? null),
            self::stringOrNull($attributes['number_suffix'] ?? null),
            self::stringOrNull($attributes['number'] ?? null),
            self::stringOrNull($attributes['create_date'] ?? null),
            self::stringOrNull($attributes['journal_date'] ?? null),
            self::stringOrNull($attributes['status'] ?? null),
            self::stringOrNull($attributes['payment_status'] ?? null),
            self::floatOrNull($attributes['net_price'] ?? null),
            self::floatOrNull($attributes['vat5_price'] ?? null),
            self::floatOrNull($attributes['vat9_price'] ?? null),
            self::floatOrNull($attributes['vat20_price'] ?? null),
            self::floatOrNull($attributes['gross_price'] ?? null),
            self::stringOrNull($attributes['bank_ref_number'] ?? null),
            self::intOrNull($attributes['term_days'] ?? null),
            self::floatOrNull($attributes['overdue_charge'] ?? null),
            self::stringOrNull($attributes['notes'] ?? null),
            self::intOrNull($attributes['base_document_files_id'] ?? null),
            self::intOrNull($attributes['files_id'] ?? null),
            self::boolOrNull($attributes['is_doubtful'] ?? null),
            self::boolOrNull($attributes['is_hopeless'] ?? null),
            self::boolOrNull($attributes['use_per_item_rounding'] ?? null),
            self::boolOrNull($attributes['paid_in_cash'] ?? null),
            self::intOrNull($attributes['cash_accounts_id'] ?? null),
            self::intOrNull($attributes['cash_accounts_dimensions_id'] ?? null),
            self::stringOrNull($attributes['invoice_info'] ?? null),
            self::stringOrNull($attributes['payment_description'] ?? null),
            self::stringOrNull($attributes['cl_currencies_id'] ?? null),
            self::floatOrNull($attributes['currency_rate'] ?? null),
            self::floatOrNull($attributes['base_gross_price'] ?? null),
            self::floatOrNull($attributes['base_net_price'] ?? null),
            self::floatOrNull($attributes['base_vat5_price'] ?? null),
            self::floatOrNull($attributes['base_vat9_price'] ?? null),
            self::floatOrNull($attributes['base_vat20_price'] ?? null),
            self::stringOrNull($attributes['cash_payment_date'] ?? null),
            self::boolOrNull($attributes['trade_secret'] ?? null),
            self::intOrNull($attributes['receivable_accounts_id'] ?? null),
            self::intOrNull($attributes['receivable_accounts_dimensions_id'] ?? null),
            self::boolOrNull($attributes['intra_community_supply'] ?? null),
            self::stringOrNull($attributes['client_vat_no'] ?? null),
            self::boolOrNull($attributes['triangulation'] ?? null),
            self::boolOrNull($attributes['assembled_in_member_state'] ?? null),
            self::boolOrNull($attributes['show_client_balance'] ?? null),
            self::intOrNull($attributes['subclients_id'] ?? null),
            self::boolOrNull($attributes['is_xls_imported'] ?? null),
            self::intOrNull($attributes['recipient_clients_id'] ?? null),
            self::intOrNull($attributes['recipient_subclients_id'] ?? null),
            self::stringOrNull($attributes['contract_number'] ?? null),
            self::stringOrNull($attributes['invoice_content_code'] ?? null),
            self::stringOrNull($attributes['invoice_content_text'] ?? null),
            self::stringOrNull($attributes['period_start_date'] ?? null),
            self::stringOrNull($attributes['period_end_date'] ?? null),
            self::stringOrNull($attributes['additional_info_content'] ?? null),
            self::intOrNull($attributes['bank_payment_orders_id'] ?? null),
            self::intOrNull($attributes['bank_accounts_id'] ?? null),
            self::stringOrNull($attributes['triangulation_seller_invoice_vat_no'] ?? null),
            $items,
            $deliveries,
            self::intList($attributes['credit_invoices'] ?? null),
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
            'credit_sale_invoices_id' => $this->creditSaleInvoicesId,
            'credit_invoice_payment_type' => $this->creditInvoicePaymentType,
            'sale_invoice_type' => $this->saleInvoiceType,
            'cl_templates_id' => $this->clTemplatesId,
            'clients_id' => $this->clientsId,
            'client_name' => $this->clientName,
            'cl_countries_id' => $this->clCountriesId,
            'number_prefix' => $this->numberPrefix,
            'number_suffix' => $this->numberSuffix,
            'number' => $this->number,
            'create_date' => $this->createDate,
            'journal_date' => $this->journalDate,
            'status' => $this->status,
            'payment_status' => $this->paymentStatus,
            'net_price' => $this->netPrice,
            'vat5_price' => $this->vat5Price,
            'vat9_price' => $this->vat9Price,
            'vat20_price' => $this->vat20Price,
            'gross_price' => $this->grossPrice,
            'bank_ref_number' => $this->bankRefNumber,
            'term_days' => $this->termDays,
            'overdue_charge' => $this->overdueCharge,
            'notes' => $this->notes,
            'base_document_files_id' => $this->baseDocumentFilesId,
            'files_id' => $this->filesId,
            'is_doubtful' => $this->isDoubtful,
            'is_hopeless' => $this->isHopeless,
            'use_per_item_rounding' => $this->usePerItemRounding,
            'paid_in_cash' => $this->paidInCash,
            'cash_accounts_id' => $this->cashAccountsId,
            'cash_accounts_dimensions_id' => $this->cashAccountsDimensionsId,
            'invoice_info' => $this->invoiceInfo,
            'payment_description' => $this->paymentDescription,
            'cl_currencies_id' => $this->clCurrenciesId,
            'currency_rate' => $this->currencyRate,
            'base_gross_price' => $this->baseGrossPrice,
            'base_net_price' => $this->baseNetPrice,
            'base_vat5_price' => $this->baseVat5Price,
            'base_vat9_price' => $this->baseVat9Price,
            'base_vat20_price' => $this->baseVat20Price,
            'cash_payment_date' => $this->cashPaymentDate,
            'trade_secret' => $this->tradeSecret,
            'receivable_accounts_id' => $this->receivableAccountsId,
            'receivable_accounts_dimensions_id' => $this->receivableAccountsDimensionsId,
            'intra_community_supply' => $this->intraCommunitySupply,
            'client_vat_no' => $this->clientVatNo,
            'triangulation' => $this->triangulation,
            'assembled_in_member_state' => $this->assembledInMemberState,
            'show_client_balance' => $this->showClientBalance,
            'subclients_id' => $this->subclientsId,
            'is_xls_imported' => $this->isXlsImported,
            'recipient_clients_id' => $this->recipientClientsId,
            'recipient_subclients_id' => $this->recipientSubclientsId,
            'contract_number' => $this->contractNumber,
            'invoice_content_code' => $this->invoiceContentCode,
            'invoice_content_text' => $this->invoiceContentText,
            'period_start_date' => $this->periodStartDate,
            'period_end_date' => $this->periodEndDate,
            'additional_info_content' => $this->additionalInfoContent,
            'bank_payment_orders_id' => $this->bankPaymentOrdersId,
            'bank_accounts_id' => $this->bankAccountsId,
            'triangulation_seller_invoice_vat_no' => $this->triangulationSellerInvoiceVatNo,
            'items' => array_map(
                static fn (SaleInvoiceItemResponse $item): array => $item->toArray(),
                $this->items,
            ),
            'deliveries' => array_map(
                static fn (SaleInvoiceDeliveryResponse $delivery): array => $delivery->toArray(),
                $this->deliveries,
            ),
            'credit_invoices' => $this->creditInvoices,
            'journals' => $this->journals,
            'settlements' => $this->settlements,
            'transactions' => $this->transactions,
        ];
    }
}
