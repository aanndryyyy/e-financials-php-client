<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Clients;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `Clients` schema, plus example-backed fields
 * that appear in live/API examples but are omitted from `properties`
 * (`is_deleted`, `is_associate_company`, `is_parent_company_group`, `is_related_party`).
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-clients_one
 *
 * @phpstan-type ClientData array{
 *     id: int|null,
 *     is_client: bool,
 *     is_supplier: bool,
 *     is_staff: bool|null,
 *     name: string,
 *     alt_name: string|null,
 *     code: string|null,
 *     address_ads_oid: string|null,
 *     address_adr_id: string|null,
 *     address_text: string|null,
 *     postal_address_text: string|null,
 *     email: string|null,
 *     accounting_email: string|null,
 *     telephone: string|null,
 *     contact_person: string|null,
 *     bank_account_no: string|null,
 *     notes: string|null,
 *     invoice_electronic_opts: array<string, string>,
 *     invoice_days: int|null,
 *     invoice_overdue_charge: float|null,
 *     invoice_vat_no: string|null,
 *     cl_invoice_country: string|null,
 *     cl_purchase_articles_id: int|null,
 *     purchase_accounts_id: int|null,
 *     purchase_accounts_dimensions_id: int|null,
 *     is_physical_entity: bool|null,
 *     is_juridical_entity: bool|null,
 *     cl_code_country: string|null,
 *     is_member: bool,
 *     send_invoice_to_email: bool,
 *     send_invoice_to_accounting_email: bool,
 *     bank_ref_number_sales: string|null,
 *     bank_ref_number_purchases: string|null,
 *     bank_account_custom_name: string|null,
 *     is_deleted: bool|null,
 *     is_associate_company: bool|null,
 *     is_parent_company_group: bool|null,
 *     is_related_party: bool|null
 * }
 *
 * @implements ResponseContract<ClientData>
 */
final class ClientResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<ClientData>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<string, string>  $invoiceElectronicOpts
     */
    private function __construct(
        public readonly ?int $id,
        public readonly bool $isClient,
        public readonly bool $isSupplier,
        public readonly ?bool $isStaff,
        public readonly string $name,
        public readonly ?string $altName,
        public readonly ?string $code,
        public readonly ?string $addressAdsOid,
        public readonly ?string $addressAdrId,
        public readonly ?string $addressText,
        public readonly ?string $postalAddressText,
        public readonly ?string $email,
        public readonly ?string $accountingEmail,
        public readonly ?string $telephone,
        public readonly ?string $contactPerson,
        public readonly ?string $bankAccountNo,
        public readonly ?string $notes,
        public readonly array $invoiceElectronicOpts,
        public readonly ?int $invoiceDays,
        public readonly ?float $invoiceOverdueCharge,
        public readonly ?string $invoiceVatNo,
        public readonly ?string $clInvoiceCountry,
        public readonly ?int $clPurchaseArticlesId,
        public readonly ?int $purchaseAccountsId,
        public readonly ?int $purchaseAccountsDimensionsId,
        public readonly ?bool $isPhysicalEntity,
        public readonly ?bool $isJuridicalEntity,
        public readonly ?string $clCodeCountry,
        public readonly bool $isMember,
        public readonly bool $sendInvoiceToEmail,
        public readonly bool $sendInvoiceToAccountingEmail,
        public readonly ?string $bankRefNumberSales,
        public readonly ?string $bankRefNumberPurchases,
        public readonly ?string $bankAccountCustomName,
        public readonly ?bool $isDeleted,
        public readonly ?bool $isAssociateCompany,
        public readonly ?bool $isParentCompanyGroup,
        public readonly ?bool $isRelatedParty,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var array<string, string> $invoiceElectronicOpts */
        $invoiceElectronicOpts = [];
        if (isset($attributes['invoice_electronic_opts']) && is_array($attributes['invoice_electronic_opts'])) {
            foreach ($attributes['invoice_electronic_opts'] as $key => $value) {
                $stringValue = self::stringOrNull($value);
                if ($stringValue === null) {
                    continue;
                }

                $invoiceElectronicOpts[is_string($key) ? $key : (string) $key] = $stringValue;
            }
        }

        $name = self::stringOrNull($attributes['name'] ?? null) ?? '';

        return new self(
            self::intOrNull($attributes['id'] ?? null),
            (bool) ($attributes['is_client'] ?? false),
            (bool) ($attributes['is_supplier'] ?? false),
            self::boolOrNull($attributes['is_staff'] ?? null),
            $name,
            self::stringOrNull($attributes['alt_name'] ?? null),
            self::stringOrNull($attributes['code'] ?? null),
            self::stringOrNull($attributes['address_ads_oid'] ?? null),
            self::stringOrNull($attributes['address_adr_id'] ?? null),
            self::stringOrNull($attributes['address_text'] ?? null),
            self::stringOrNull($attributes['postal_address_text'] ?? null),
            self::stringOrNull($attributes['email'] ?? null),
            self::stringOrNull($attributes['accounting_email'] ?? null),
            self::stringOrNull($attributes['telephone'] ?? null),
            self::stringOrNull($attributes['contact_person'] ?? null),
            self::stringOrNull($attributes['bank_account_no'] ?? null),
            self::stringOrNull($attributes['notes'] ?? null),
            $invoiceElectronicOpts,
            self::intOrNull($attributes['invoice_days'] ?? null),
            self::floatOrNull($attributes['invoice_overdue_charge'] ?? null),
            self::stringOrNull($attributes['invoice_vat_no'] ?? null),
            self::stringOrNull($attributes['cl_invoice_country'] ?? null),
            self::intOrNull($attributes['cl_purchase_articles_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_id'] ?? null),
            self::intOrNull($attributes['purchase_accounts_dimensions_id'] ?? null),
            self::boolOrNull($attributes['is_physical_entity'] ?? null),
            self::boolOrNull($attributes['is_juridical_entity'] ?? null),
            self::stringOrNull($attributes['cl_code_country'] ?? null),
            (bool) ($attributes['is_member'] ?? false),
            (bool) ($attributes['send_invoice_to_email'] ?? false),
            (bool) ($attributes['send_invoice_to_accounting_email'] ?? false),
            self::stringOrNull($attributes['bank_ref_number_sales'] ?? null),
            self::stringOrNull($attributes['bank_ref_number_purchases'] ?? null),
            self::stringOrNull($attributes['bank_account_custom_name'] ?? null),
            self::boolOrNull($attributes['is_deleted'] ?? null),
            self::boolOrNull($attributes['is_associate_company'] ?? null),
            self::boolOrNull($attributes['is_parent_company_group'] ?? null),
            self::boolOrNull($attributes['is_related_party'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'is_client' => $this->isClient,
            'is_supplier' => $this->isSupplier,
            'is_staff' => $this->isStaff,
            'name' => $this->name,
            'alt_name' => $this->altName,
            'code' => $this->code,
            'address_ads_oid' => $this->addressAdsOid,
            'address_adr_id' => $this->addressAdrId,
            'address_text' => $this->addressText,
            'postal_address_text' => $this->postalAddressText,
            'email' => $this->email,
            'accounting_email' => $this->accountingEmail,
            'telephone' => $this->telephone,
            'contact_person' => $this->contactPerson,
            'bank_account_no' => $this->bankAccountNo,
            'notes' => $this->notes,
            'invoice_electronic_opts' => $this->invoiceElectronicOpts,
            'invoice_days' => $this->invoiceDays,
            'invoice_overdue_charge' => $this->invoiceOverdueCharge,
            'invoice_vat_no' => $this->invoiceVatNo,
            'cl_invoice_country' => $this->clInvoiceCountry,
            'cl_purchase_articles_id' => $this->clPurchaseArticlesId,
            'purchase_accounts_id' => $this->purchaseAccountsId,
            'purchase_accounts_dimensions_id' => $this->purchaseAccountsDimensionsId,
            'is_physical_entity' => $this->isPhysicalEntity,
            'is_juridical_entity' => $this->isJuridicalEntity,
            'cl_code_country' => $this->clCodeCountry,
            'is_member' => $this->isMember,
            'send_invoice_to_email' => $this->sendInvoiceToEmail,
            'send_invoice_to_accounting_email' => $this->sendInvoiceToAccountingEmail,
            'bank_ref_number_sales' => $this->bankRefNumberSales,
            'bank_ref_number_purchases' => $this->bankRefNumberPurchases,
            'bank_account_custom_name' => $this->bankAccountCustomName,
            'is_deleted' => $this->isDeleted,
            'is_associate_company' => $this->isAssociateCompany,
            'is_parent_company_group' => $this->isParentCompanyGroup,
            'is_related_party' => $this->isRelatedParty,
        ];
    }

    private static function stringOrNull(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_string($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        return null;
    }

    private static function intOrNull(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_int($value)) {
            return $value;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }

    private static function floatOrNull(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_float($value)) {
            return $value;
        }

        if (is_int($value) || (is_string($value) && is_numeric($value))) {
            return (float) $value;
        }

        return null;
    }

    private static function boolOrNull(mixed $value): ?bool
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_bool($value)) {
            return $value;
        }

        if (is_int($value) || is_float($value) || is_string($value)) {
            return (bool) $value;
        }

        return null;
    }
}
