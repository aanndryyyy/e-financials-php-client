<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Invoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `CompanyInvoiceInfo` schema.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-invoice_info
 *
 * @phpstan-type InvoiceInfoData array{
 *     address: string|null,
 *     email: string|null,
 *     phone: string|null,
 *     fax: string|null,
 *     webpage: string|null,
 *     cl_templates_id: int|null,
 *     invoice_company_name: string|null,
 *     invoice_email_subject: string|null,
 *     invoice_email_body: string|null,
 *     balance_email_subject: string|null,
 *     balance_email_body: string|null,
 *     balance_document_footer: string|null
 * }
 *
 * @implements ResponseContract<InvoiceInfoData>
 */
final class InvoiceInfoResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<InvoiceInfoData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?string $address,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $fax,
        public readonly ?string $webpage,
        public readonly ?int $clTemplatesId,
        public readonly ?string $invoiceCompanyName,
        public readonly ?string $invoiceEmailSubject,
        public readonly ?string $invoiceEmailBody,
        public readonly ?string $balanceEmailSubject,
        public readonly ?string $balanceEmailBody,
        public readonly ?string $balanceDocumentFooter,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::stringOrNull($attributes['address'] ?? null),
            self::stringOrNull($attributes['email'] ?? null),
            self::stringOrNull($attributes['phone'] ?? null),
            self::stringOrNull($attributes['fax'] ?? null),
            self::stringOrNull($attributes['webpage'] ?? null),
            self::intOrNull($attributes['cl_templates_id'] ?? null),
            self::stringOrNull($attributes['invoice_company_name'] ?? null),
            self::stringOrNull($attributes['invoice_email_subject'] ?? null),
            self::stringOrNull($attributes['invoice_email_body'] ?? null),
            self::stringOrNull($attributes['balance_email_subject'] ?? null),
            self::stringOrNull($attributes['balance_email_body'] ?? null),
            self::stringOrNull($attributes['balance_document_footer'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'fax' => $this->fax,
            'webpage' => $this->webpage,
            'cl_templates_id' => $this->clTemplatesId,
            'invoice_company_name' => $this->invoiceCompanyName,
            'invoice_email_subject' => $this->invoiceEmailSubject,
            'invoice_email_body' => $this->invoiceEmailBody,
            'balance_email_subject' => $this->balanceEmailSubject,
            'balance_email_body' => $this->balanceEmailBody,
            'balance_document_footer' => $this->balanceDocumentFooter,
        ];
    }
}
