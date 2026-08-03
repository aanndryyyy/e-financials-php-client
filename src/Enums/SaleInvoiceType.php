<?php

declare(strict_types=1);

namespace EFinancialsClient\Enums;

/**
 * Document type of a sale invoice, matching the tabs in the e-Arveldaja web UI.
 *
 * The values are not part of the published OpenAPI spec and are not validated
 * server-side: sending an unrecognised one alongside `credit_sale_invoices_id`
 * makes the API answer with HTTP 500 instead of a validation error.
 *
 * | UI tab           | value                 |
 * |------------------|-----------------------|
 * | Müügiarved       | `INVOICE`             |
 * | Kreeditarved     | `CREDIT-INVOICE`      |
 * | Ettemaksuarved   | `PREPAYMENT-INVOICE`  |
 * | Hinnapakkumised  | `QUOTATION`           |
 */
enum SaleInvoiceType: string
{
    case INVOICE = 'INVOICE';
    case CREDIT_INVOICE = 'CREDIT-INVOICE';
    case PREPAYMENT_INVOICE = 'PREPAYMENT-INVOICE';
    case QUOTATION = 'QUOTATION';
}
