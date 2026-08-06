<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Payment status of a sale or purchase invoice, as accepted by the
 * `payment_status` query parameter.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices
 * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices
 */
enum PaymentStatus: string
{
    case PAID = 'PAID';
    case PARTIALLY_PAID = 'PARTIALLY_PAID';
    case NOT_PAID = 'NOT_PAID';
}
