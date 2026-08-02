<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Clients;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array{id: int, name: string, is_client: bool, is_supplier: bool, code: string|null, cl_code_country: string|null, is_member: bool, send_invoice_to_email: bool, send_invoice_to_accounting_email: bool, is_deleted: bool}>
 */
final class ClientResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array{id: int, name: string, is_client: bool, is_supplier: bool, code: string|null, cl_code_country: string|null, is_member: bool, send_invoice_to_email: bool, send_invoice_to_accounting_email: bool, is_deleted: bool}>
     */
    use ArrayAccessible;

    use Fakeable;

    private function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly bool $isClient,
        public readonly bool $isSupplier,
        public readonly ?string $code,
        public readonly ?string $clCodeCountry,
        public readonly bool $isMember,
        public readonly bool $sendInvoiceToEmail,
        public readonly bool $sendInvoiceToAccountingEmail,
        public readonly bool $isDeleted,
    ) {}

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        /** @var int|numeric-string $id */
        $id = $attributes['id'];
        /** @var string $name */
        $name = $attributes['name'];
        /** @var string|null $code */
        $code = $attributes['code'] ?? null;
        /** @var string|null $clCodeCountry */
        $clCodeCountry = $attributes['cl_code_country'] ?? null;

        return new self(
            (int) $id,
            $name,
            (bool) ($attributes['is_client'] ?? false),
            (bool) ($attributes['is_supplier'] ?? false),
            $code,
            $clCodeCountry,
            (bool) ($attributes['is_member'] ?? false),
            (bool) ($attributes['send_invoice_to_email'] ?? false),
            (bool) ($attributes['send_invoice_to_accounting_email'] ?? false),
            (bool) ($attributes['is_deleted'] ?? false),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'is_client' => $this->isClient,
            'is_supplier' => $this->isSupplier,
            'code' => $this->code,
            'cl_code_country' => $this->clCodeCountry,
            'is_member' => $this->isMember,
            'send_invoice_to_email' => $this->sendInvoiceToEmail,
            'send_invoice_to_accounting_email' => $this->sendInvoiceToAccountingEmail,
            'is_deleted' => $this->isDeleted,
        ];
    }
}
