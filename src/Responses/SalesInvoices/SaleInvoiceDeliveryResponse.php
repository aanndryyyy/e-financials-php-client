<?php

declare(strict_types=1);

namespace EFinancialsClient\Responses\SalesInvoices;

use EFinancialsClient\Contracts\ResponseContract;
use EFinancialsClient\Responses\Concerns\ArrayAccessible;
use EFinancialsClient\Responses\Concerns\NormalizesAttributes;
use EFinancialsClient\Testing\Responses\Concerns\Fakeable;

/**
 * Full projection of the OpenAPI `SaleInvoicesDeliveries` schema.
 *
 * @see https://rmp-api.rik.ee/openapi.yaml
 *
 * @phpstan-type SaleInvoiceDeliveryData array{
 *     create_date: string|null,
 *     destination_type: string|null,
 *     invoice_type: string|null,
 *     receiver_address: string|null,
 *     receiver_name: string|null,
 *     send_method: int|null,
 *     sender_person_code: string|null,
 *     sender_person_name: string|null,
 *     status_date: string|null,
 *     transfer_status_code: int|null
 * }
 *
 * @implements ResponseContract<SaleInvoiceDeliveryData>
 */
final class SaleInvoiceDeliveryResponse implements ResponseContract
{
    /**
     * @use ArrayAccessible<SaleInvoiceDeliveryData>
     */
    use ArrayAccessible;

    use Fakeable;
    use NormalizesAttributes;

    private function __construct(
        public readonly ?string $createDate,
        public readonly ?string $destinationType,
        public readonly ?string $invoiceType,
        public readonly ?string $receiverAddress,
        public readonly ?string $receiverName,
        public readonly ?int $sendMethod,
        public readonly ?string $senderPersonCode,
        public readonly ?string $senderPersonName,
        public readonly ?string $statusDate,
        public readonly ?int $transferStatusCode,
    ) {}

    /**
     * @param  array<array-key, mixed>  $attributes
     */
    public static function from(array $attributes): self
    {
        return new self(
            self::stringOrNull($attributes['create_date'] ?? null),
            self::stringOrNull($attributes['destination_type'] ?? null),
            self::stringOrNull($attributes['invoice_type'] ?? null),
            self::stringOrNull($attributes['receiver_address'] ?? null),
            self::stringOrNull($attributes['receiver_name'] ?? null),
            self::intOrNull($attributes['send_method'] ?? null),
            self::stringOrNull($attributes['sender_person_code'] ?? null),
            self::stringOrNull($attributes['sender_person_name'] ?? null),
            self::stringOrNull($attributes['status_date'] ?? null),
            self::intOrNull($attributes['transfer_status_code'] ?? null),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function toArray(): array
    {
        return [
            'create_date' => $this->createDate,
            'destination_type' => $this->destinationType,
            'invoice_type' => $this->invoiceType,
            'receiver_address' => $this->receiverAddress,
            'receiver_name' => $this->receiverName,
            'send_method' => $this->sendMethod,
            'sender_person_code' => $this->senderPersonCode,
            'sender_person_name' => $this->senderPersonName,
            'status_date' => $this->statusDate,
            'transfer_status_code' => $this->transferStatusCode,
        ];
    }
}
