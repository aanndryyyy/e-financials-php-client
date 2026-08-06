<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Type of a transaction, as accepted by the `type` query parameter.
 *
 * The spec describes the underlying field only as
 * "type - incoming payment/outgoing payment/settlement" without saying
 * which value is which; `C` is credit and `D` is debit.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
 */
enum TransactionType: string
{
    case CREDIT = 'C';
    case DEBIT = 'D';
}
