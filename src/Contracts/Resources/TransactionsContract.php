<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Enums\TransactionStatus;
use EFinancialsClient\Enums\TransactionType;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Transactions\ListResponse;
use EFinancialsClient\Responses\Transactions\TransactionResponse;

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
     * @param  TransactionStatus|string  $status  Object status.
     * @param  TransactionType|string  $type  Object type.
     * @param  int|null  $clientsId  Customer identificator.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = '', TransactionStatus|string $status = '', TransactionType|string $type = '', ?int $clientsId = null): ListResponse;

    /**
     * Retrieve one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function get(int $id): TransactionResponse;

    /**
     * Create a new transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-transactions
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one
     *
     * @param  int  $id  Transaction identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Register one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_register
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<int, array<string, mixed>>  $distributions  Optional transaction distribution rows.
     */
    public function register(int $id, array $distributions = []): ApiResponse;

    /**
     * Invalidate one specific transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-transactions_one_invalidate
     *
     * @param  int  $id  Transaction identificator.
     */
    public function invalidate(int $id): ApiResponse;

    /**
     * Retrieve the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function getFile(int $id): ApiFileResponse;

    /**
     * Update the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     * @param  array<string, mixed>  $parameters  Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): ApiResponse;

    /**
     * Delete the document related to a transaction of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-transactions_one_document_user
     *
     * @param  int  $id  Transaction identificator.
     */
    public function deleteFile(int $id): ApiResponse;
}
