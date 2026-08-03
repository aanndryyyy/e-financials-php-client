<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Enums\SaleInvoiceType;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\SalesInvoices\ListResponse;
use EFinancialsClient\Responses\SalesInvoices\SaleInvoiceDeliveryOptionsResponse;
use EFinancialsClient\Responses\SalesInvoices\SaleInvoiceResponse;

interface SalesInvoicesContract
{
    /**
     * Retrieve the sale invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Object revenue date on given date or later.
     * @param  DateTime|string  $endDate  Object revenue date on given date or before.
     * @param  string  $status  Object status.
     * @param  string  $paymentStatus  Object payment status.
     * @param  int|null  $clientsId  Customer identificator.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = '', string $status = '', string $paymentStatus = '', ?int $clientsId = null): ListResponse;

    /**
     * Retrieve one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function get(int $id): SaleInvoiceResponse;

    /**
     * Create a new sale invoice of the specified company.
     *
     * `sale_invoice_type` accepts a `SaleInvoiceType` case as well as a raw string.
     * Credit invoices (kreeditarve) are created here too: `SaleInvoiceType::CREDIT_INVOICE`
     * plus `credit_sale_invoices_id`, the original's `number_suffix` and negative
     * `items[].amount`.
     *
     * @see SaleInvoiceType
     * @see https://rmp-api.rik.ee/api.html#operation/post-sale_invoices
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific sale invoice of the specified company.
     *
     * `sale_invoice_type` accepts a `SaleInvoiceType` case as well as a raw string.
     * Do not use this to turn an existing invoice into a credit invoice — see the
     * implementation for why that books the wrong accounting.
     *
     * @see SaleInvoiceType
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Register one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_register
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function register(int $id): ApiResponse;

    /**
     * Invalidate one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_invalidate
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function invalidate(int $id): ApiResponse;

    /**
     * Retrieve the system-generated XML e-invoice related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_xml
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getXml(int $id): ApiFileResponse;

    /**
     * Retrieve the system-generated PDF related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_system
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getSystemPdf(int $id): ApiFileResponse;

    /**
     * Retrieve the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getFile(int $id): ApiFileResponse;

    /**
     * Update the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     * @param  array<string, mixed>  $parameters  Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): ApiResponse;

    /**
     * Delete the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function deleteFile(int $id): ApiResponse;

    /**
     * Retrieve delivery options for one specific sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_delivery_opts
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getDeliveryOptions(int $id): SaleInvoiceDeliveryOptionsResponse;

    /**
     * Send one specific sale invoice to the customer.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_deliver
     *
     * @param  int  $id  Sale invoice identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function deliver(int $id, array $parameters): ApiResponse;
}
