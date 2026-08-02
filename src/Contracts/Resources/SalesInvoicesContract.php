<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;

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
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = '', string $status = '', string $paymentStatus = '', ?int $clientsId = null): mixed;

    /**
     * Retrieve one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function get(int $id): mixed;

    /**
     * Create a new sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-sale_invoices
     *
     * @param array<string,mixed>|array{
     *   "sale_invoice_type": "INVOICE",
     *   "cl_templates_id": 1,
     *   "clients_id": 126,
     *   "cl_countries_id": "EST",
     *   "number_suffix": "91",
     *   "create_date": "2016-02-15",
     *   "journal_date": "2016-02-15",
     *   "term_days": 30,
     *   "cl_currencies_id": "EUR",
     *   "show_client_balance": false
     * } $parameters
     */
    public function create(array $parameters = []): mixed;

    /**
     * Modify one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "sale_invoice_type": "INVOICE",
     *   "cl_templates_id": 1,
     *   "clients_id": 126,
     *   "cl_countries_id": "EST",
     *   "number_suffix": "91",
     *   "create_date": "2016-02-15",
     *   "journal_date": "2016-02-15",
     *   "term_days": 30,
     *   "cl_currencies_id": "EUR",
     *   "show_client_balance": false
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed;

    /**
     * Delete one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function delete(int $id): mixed;

    /**
     * Register one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_register
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function register(int $id): mixed;

    /**
     * Invalidate one specific sale invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_invalidate
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function invalidate(int $id): mixed;

    /**
     * Retrieve the system-generated XML e-invoice related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_xml
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getXml(int $id): mixed;

    /**
     * Retrieve the system-generated PDF related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_system
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getSystemPdf(int $id): mixed;

    /**
     * Retrieve the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getFile(int $id): mixed;

    /**
     * Update the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "name": string,
     *   "contents": string,
     * } $parameters Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): mixed;

    /**
     * Delete the user-uploaded document related to a sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-sale_invoices_one_document_user
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function deleteFile(int $id): mixed;

    /**
     * Retrieve delivery options for one specific sale invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-sale_invoices_one_delivery_opts
     *
     * @param  int  $id  Sale invoice identificator.
     */
    public function getDeliveryOptions(int $id): mixed;

    /**
     * Send one specific sale invoice to the customer.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-sale_invoices_one_deliver
     *
     * @param  int  $id  Sale invoice identificator.
     * @param array<string,mixed>|array{
     *   "send_einvoice": bool,
     *   "send_email": bool,
     *   "email_addresses": string,
     *   "email_subject": string,
     *   "email_body": string,
     * } $parameters
     */
    public function deliver(int $id, array $parameters): mixed;
}
