<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Status of a transaction, as accepted by the `status` query parameter.
 *
 * Note this differs from {@see InvoiceStatus}, which has no `VOID` case.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
 */
enum TransactionStatus: string
{
    case PROJECT = 'PROJECT';
    case CONFIRMED = 'CONFIRMED';
    case VOID = 'VOID';
}
