<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;

interface TransactionsContract
{
    /**
     * Retrieve the transaction list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Date on given date or later.
     * @param  DateTime|string  $endDate  Date on given date or before.
     * @param  string  $status  Object status.
     * @param  string  $type  Object type.
     * @param  int|null  $clientsId  Customer identificator.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = '', string $status = '', string $type = '', ?int $clientsId = null): mixed;

    /**
     * Retrieve one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function get(int $id): mixed;

    /**
     * Create a new transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-transactions
     *
     * @param array<string,mixed>|array{
     *   "accounts_dimensions_id": int,
     *   "type": "D"|"C",
     *   "amount": float,
     *   "cl_currencies_id": "EUR",
     *   "date": "2015-01-31",
     *   "description": string,
     *   "clients_id": int,
     * } $parameters
     */
    public function create(array $parameters = []): mixed;

    /**
     * Modify one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     * @param array<string,mixed>|array{
     *   "accounts_dimensions_id": int,
     *   "type": "D"|"C",
     *   "amount": float,
     *   "cl_currencies_id": "EUR",
     *   "date": "2015-01-31",
     *   "description": string,
     *   "clients_id": int,
     * } $parameters
     */
    public function update(int $id, array $parameters): mixed;

    /**
     * Delete one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function delete(int $id): mixed;

    /**
     * Register one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_register
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<int, mixed>  $distributions  Optional transaction distribution rows.
     */
    public function register(int $id, array $distributions = []): mixed;

    /**
     * Invalidate one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_invalidate
     *
     * @param  int  $id  Transaction identificator.
     */
    public function invalidate(int $id): mixed;

    /**
     * Retrieve the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function getFile(int $id): mixed;

    /**
     * Update the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     * @param array<string,mixed>|array{
     *   "name": string,
     *   "contents": string,
     * } $parameters Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): mixed;

    /**
     * Delete the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function deleteFile(int $id): mixed;
}
