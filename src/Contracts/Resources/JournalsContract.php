<?php

declare(strict_types=1);

namespace EFinancialsClient\Contracts\Resources;

use DateTime;
use EFinancialsClient\Responses\ApiFileResponse;
use EFinancialsClient\Responses\ApiResponse;
use EFinancialsClient\Responses\Journals\JournalResponse;
use EFinancialsClient\Responses\Journals\ListResponse;

interface JournalsContract
{
    /**
     * Retrieve the journal entry list of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals
     *
     * @param  int  $page  Page of responses to return.
     * @param  DateTime|string  $modifiedSince  Return only objects modified since provided timestamp.
     * @param  DateTime|string  $startDate  Effective date on given date or later.
     * @param  DateTime|string  $endDate  Effective date on given date or before.
     */
    public function all(int $page = 1, DateTime|string $modifiedSince = '', DateTime|string $startDate = '', DateTime|string $endDate = ''): ListResponse;

    /**
     * Retrieve one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function get(int $id): JournalResponse;

    /**
     * Create a new journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/post-journals
     *
     * @param  array<string, mixed>  $parameters
     */
    public function create(array $parameters = []): ApiResponse;

    /**
     * Modify one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     * @param  array<string, mixed>  $parameters
     */
    public function update(int $id, array $parameters): ApiResponse;

    /**
     * Delete one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function delete(int $id): ApiResponse;

    /**
     * Register one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_register
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function register(int $id): ApiResponse;

    /**
     * Invalidate one specific journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/patch-journals_one_invalidate
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function invalidate(int $id): ApiResponse;

    /**
     * Retrieve the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/get-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function getFile(int $id): ApiFileResponse;

    /**
     * Update the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/put-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     * @param  array<string, mixed>  $parameters  Base64-encoded file payload.
     */
    public function updateFile(int $id, array $parameters): ApiResponse;

    /**
     * Delete the document related to a journal entry of the specified company.
     *
     * @see https://rmp-api.rik.ee/api.html#operation/delete-journals_one_document_user
     *
     * @param  int  $id  Journal entry identificator.
     */
    public function deleteFile(int $id): ApiResponse;
}
