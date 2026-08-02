<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `SaleInvoicesDeliveryOptions` schema.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_delivery_opts
 *
 * @phpstan-type SaleInvoiceDeliveryOptionsData array{
 *     can_send_einvoice: bool,
 *     can_send_einvoice_reason: string|null,
 *     can_send_email: bool,
 *     can_send_email_addresses: string|null
 * }
 *
 * @implements ResponseContract<SaleInvoiceDeliveryOptionsData>
 */
final class SaleInvoiceDeliveryOptionsResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<SaleInvoiceDeliveryOptionsData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly bool $canSendEinvoice,
        public readonly ?string $canSendEinvoiceReason,
        public readonly bool $canSendEmail,
        public readonly ?string $canSendEmailAddresses,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::boolValue($attributes['can_send_einvoice'] ?? null),
            self::stringOrNull($attributes['can_send_einvoice_reason'] ?? null),
            self::boolValue($attributes['can_send_email'] ?? null),
            self::stringOrNull($attributes['can_send_email_addresses'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'can_send_einvoice' => $this->canSendEinvoice,
            'can_send_einvoice_reason' => $this->canSendEinvoiceReason,
            'can_send_email' => $this->canSendEmail,
            'can_send_email_addresses' => $this->canSendEmailAddresses,
        ];
    }
}
