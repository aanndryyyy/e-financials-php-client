<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Status of a sale or purchase invoice, as accepted by the `status`
 * query parameter.
 *
 * Note this differs from {@see TransactionStatus}, which additionally
 * has a `VOID` case.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices
 * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices
 */
enum InvoiceStatus: string
{
    case PROJECT = 'PROJECT';
    case CONFIRMED = 'CONFIRMED';
}
