<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;

interface PurchaseInvoicesContract
{
    /**
     * Retrieve the purchase invoice list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Object created on given date or later.
     * @param  DateTime|string  $endDate  Object created on given date or before.
     * @param  string  $status  Object status.
     * @param  string  $paymentStatus  Object payment status.
     * @param  int|null  $clientsId  Supplier identificator.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = '', string $status = '', string $paymentStatus = '', ?int $clientsId = null): mixed;

    /**
     * Retrieve one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function get(int $id): mixed;

    /**
     * Create a new purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-purchase_invoices
     *
     * @param array<string,mixed>|array{
     *   "clients_id": 803,
     *   "client_name": string,
     *   "number": string,
     *   "create_date": "2017-08-09",
     *   "journal_date": "2017-08-09",
     *   "term_days": 0,
     *   "cl_currencies_id": "EUR"
     * } $parameters
     */
    public function create(array $parameters = []): mixed;

    /**
     * Modify one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     * @param array<string,mixed>|array{
     *   "clients_id": 803,
     *   "client_name": string,
     *   "number": string,
     *   "create_date": "2017-08-09",
     *   "journal_date": "2017-08-09",
     *   "term_days": 0,
     *   "cl_currencies_id": "EUR"
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed;

    /**
     * Delete one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function delete(int $id): mixed;

    /**
     * Register one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_register
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function register(int $id): mixed;

    /**
     * Invalidate one specific purchase invoice of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-purchase_invoices_one_invalidate
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function invalidate(int $id): mixed;

    /**
     * Retrieve the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function getFile(int $id): mixed;

    /**
     * Update the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     * @param array<string,mixed>|array{
     *   "name": string,
     *   "contents": string,
     * } $parameters Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): mixed;

    /**
     * Delete the user-uploaded document related to a purchase invoice.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-purchase_invoices_one_document_user
     *
     * @param  int  $id  Purchase invoice identificator.
     */
    public function deleteFile(int $id): mixed;
}
