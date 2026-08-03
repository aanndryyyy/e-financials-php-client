<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Type of a transaction, as accepted by the `type` query parameter.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
 */
enum TransactionType: string
{
    case CREDIT = 'C';
    case DEBIT = 'D';
}
