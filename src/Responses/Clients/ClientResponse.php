<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\Clients;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * @implements ResponseContract<array<string, mixed>>
 */
final class ClientResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<array<string, mixed>>
     */
    use ArrayAccessible;

    use Fakeable;

    /**
     * @param  array<string, mixed>  $attributes
     */
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
        private readonly array $attributes,
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
            $attributes,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return $this->attributes;
    }
}
