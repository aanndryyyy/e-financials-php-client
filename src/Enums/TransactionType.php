<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Type of a transaction, as accepted by the `type` query parameter.
 *
 * The spec describes the underlying field only as
 * "type - incoming payment/outgoing payment/settlement" and does not say
 * which of those `C` and `D` map to, so the cases are named after their
 * literal values rather than asserting a meaning.
 *
 * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
 */
enum TransactionType: string
{
    case C = 'C';
    case D = 'D';
}
